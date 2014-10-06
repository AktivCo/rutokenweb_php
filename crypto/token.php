<?php
/*
 * This file sets up class-loading and the environment
 * also tests whether GMP, BCMATH, or both are defined
 * if the GMP php extension exists it is preffered
 * because it is at least an order of magnitude faster

 */
function __autoload($f){
    //load the interfaces first otherwise contract errors occur

    $interfaceFile = $_SERVER['DOCUMENT_ROOT']."/crypto/classes/interface/" . $f . "Interface.php";
    if (file_exists($interfaceFile)) {
        require_once $interfaceFile;
    }

    //load class files after interfaces
    $classFile =$_SERVER['DOCUMENT_ROOT']."/crypto/classes/" . $f . ".php";
    if (file_exists($classFile)) {
        require_once $classFile;
    }

    //if utilities are needed load them last
    $utilFile = $_SERVER['DOCUMENT_ROOT']."/crypto/classes/util/" . $f . ".php";
    if (file_exists($utilFile)) {
        require_once $utilFile;
    }
}
 define ('USE_EXT', 'GMP');

function token_verify($Hash, $Qx, $Qy, $R, $S ) {
        
        $pGOST = GOSTcurve::generator_GOST();
        $curve_GOST = GOSTcurve::curve_GOST();
        $pubk = new PublicKey($pGOST, new Point($curve_GOST, gmp_Utils::gmp_hexdec('0x'.$Qx), gmp_Utils::gmp_hexdec('0x'.$Qy)));
        $got = $pubk->GOST_verifies(gmp_Utils::gmp_hexdec('0x'.$Hash), new Signature(gmp_Utils::gmp_hexdec('0x'.$R), gmp_Utils::gmp_hexdec('0x'.$S)));
	return $got;
}

function token_random() {
    $rnd = fullhex(hash('sha256', rand(), true));
    return $rnd;
}

function fullhex($str=NULL){
        if(is_null($str)){
                return FALSE;
        }
        $hexStr = "";
        for($i=0;isset($str[$i]);$i++){
            $char = dechex(ord($str[$i]));
	    if(strlen($char)<2){
		$hexStr .='0';
	    }
            $hexStr .= $char;
        }
    return $hexStr;
 }


function token_test() {
        $Hash = '5D5FE1DD044A577C8B6580F49394CF4B4EF2D617C60C9AB6CDF2AC14BAB359C7';
        $Qx = '16E3585053A4BE8546FB3475F1CBDD7FF1A2C9BC886BD8C1E9214C2C2A468122';
        $Qy = '6BFBA33C9F50F8F952091306C5BE17E5447D82F8EFBC0784E10234E7D7CA71A0';
        $R = '1B432A390D2871EEF2A4F4A5A607938DC4EBE6D2871A18133578F701851F37C2';
        $S = '2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC';
        if (token_verify($Hash, $Qx, $Qy, $R, $S)){
			echo "Sign valid\n";
		}else{
			echo "Sign not valid\n";
		}
}

// token_test();
?>