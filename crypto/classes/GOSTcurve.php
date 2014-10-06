<?php

/**
 * This class encapsulates the GOST recommended curves
 *  
 * @author Eugene Sukhov
 */
class GOSTcurve {

    public static function curve_GOST() {
        #  GOST Curve:
        if (extension_loaded('gmp') && USE_EXT == 'GMP') {
            $_p = gmp_Utils::gmp_hexdec('0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffd97'); 
            $_a = gmp_Utils::gmp_hexdec('0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffd94'); 
            $_b = '166';
            $curve_GOST = new CurveFp($_p, $_a, $_b);
        } else {
			return false;
        }
        return $curve_GOST;
    }	

    public static function generator_GOST() {
        #  GOST Curve:
        if (extension_loaded('gmp') && USE_EXT == 'GMP') {
            $_p = gmp_Utils::gmp_hexdec('0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffd97'); 
            $_a = gmp_Utils::gmp_hexdec('0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffd94'); 
            $_r = gmp_Utils::gmp_hexdec('0xffffffffffffffffffffffffffffffff6c611070995ad10045841b09b761b893');
	    $_b = '166';
            $_Gx ='1';
            $_Gy = gmp_Utils::gmp_hexdec('0x8d91e471e0989cda27df505a453f2b7635294f2ddf23e3b122acc99c9e9f1e14');
            $curve_GOST = new CurveFp($_p, $_a, $_b);
            $generator_GOST = new Point($curve_GOST, $_Gx, $_Gy, $_r);
        } else {
			return false;
        }
        return $generator_GOST;
    }

}
?>
