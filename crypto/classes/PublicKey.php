<?php

/**
 * This class serves as public- private key exchange for signature verification
 */
class PublicKey implements PublicKeyInterface {

    protected $curve;
    protected $generator;
    protected $point;

    public function __construct(Point $generator, Point $point) {
        $this->curve = $generator->getCurve();
        $this->generator = $generator;
        $this->point = $point;

        $n = $generator->getOrder();

        if ($n == null) {
            throw new ErrorExcpetion("Generator Must have order.");
        }
        if (Point::cmp(Point::mul($n, $point), Point::$infinity) != 0) {
            throw new ErrorException("Generator Point order is bad.");
        }

        if (extension_loaded('gmp') && USE_EXT=='GMP') {
            if (gmp_cmp($point->getX(), 0) < 0 || gmp_cmp($n, $point->getX()) <= 0 || gmp_cmp($point->getY(), 0) < 0 || gmp_cmp($n, $point->getY()) <= 0) {
                throw new ErrorException("Generator Point has x and y out of range.");
            }
        } else {
            throw new ErrorException("Please install GMP");
        }
    }

    public function GOST_verifies($hash, Signature $signature) {
        if (extension_loaded('gmp') && USE_EXT=='GMP') {
            $G = $this->generator; //P
            $n = $this->generator->getOrder();//q
            $point = $this->point; //Q
            $r = $signature->getR();
            $s = $signature->getS();

            if (gmp_cmp($r, 1) < 0 || gmp_cmp($r, gmp_sub($n, 1)) > 0) {
                return false;
            }
            if (gmp_cmp($s, 1) < 0 || gmp_cmp($s, gmp_sub($n, 1)) > 0) {
        	return false;
            }
//step 3 GOST
	    $e = gmp_Utils::gmp_mod2($hash, $n);
	    if($e==0)
		    $e=1;
// step 4 GOST
	    $v = gmp_strval(gmp_invert($e,$n));
// step 5 GOST
	    $z1 = gmp_Utils::gmp_mod2(gmp_mul($s, $v), $n);
	    $z2 = gmp_Utils::gmp_mod2(gmp_mul(gmp_neg($r), $v), $n);
// step 6 GOST
            $C = Point::add(Point::mul($z1, $G), Point::mul($z2, $point));
            $R = gmp_Utils::gmp_mod2($C->getX(), $n);

		if (0){
				echo "n - ".$n."\n";
				echo "h - ".$hash."\n";
				echo "e - ".gmp_Utils::gmp_dechex($e)."\n";		
				echo "v - ".gmp_Utils::gmp_dechex($v)."\n";
				echo "r - ".$r."\n";
				echo "s - ".$s."\n";
				echo "z1 - ".gmp_Utils::gmp_dechex($z1)."\nz2 - ".gmp_Utils::gmp_dechex($z2)."\n";
				echo "Q - ".$point."\nG - ".$G."\n";
				echo "C - ".$C."\nR - ".$R."\n";	    
		}

            if (gmp_cmp($R, $r) == 0)
                return true;
            else {
                return false;
            }
        } else {
            throw new ErrorException("Please install GMP");
        }
    }
 

    public function getCurve() {
        return $this->curve;
    }

    public function getGenerator() {
        return $this->generator;
    }

    public function getPoint() {
        return $this->point;
    }

    public function getPublicKey() {
        print_r($this);
        return $this;
    }

}
?>
