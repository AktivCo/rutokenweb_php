<?php

/**
 * This class is a representation of an EC over a field modulo a prime number
 *
 * Important objectives for this class are:
 *  - Does the curve contain a point?
 *  - Comparison of two curves.
 */
class CurveFp implements CurveFpInterface {

    //Elliptic curve over the field of integers modulo a prime
    protected $a = 0;
    protected $b = 0;
    protected $prime = 0;

    //constructor that sets up the instance variables
    public function __construct($prime, $a, $b) {
        $this->a = $a;
        $this->b = $b;
        $this->prime = $prime;
    }

    public function contains($x, $y) {
        $eq_zero = null;

        if (extension_loaded('gmp') && USE_EXT=='GMP') {

            $eq_zero = gmp_cmp(gmp_Utils::gmp_mod2(gmp_sub(gmp_pow($y, 2), gmp_add(gmp_add(gmp_pow($x, 3), gmp_mul($this->a, $x)), $this->b)), $this->prime), 0);


            if ($eq_zero == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ErrorException("Please install GMP");
        }
    }

    public function getA() {
        return $this->a;
    }

    public function getB() {
        return $this->b;
    }

    public function getPrime() {
        return $this->prime;
    }

    public static function cmp(CurveFp $cp1, CurveFp $cp2) {
        $same = null;

        if (extension_loaded('gmp') && USE_EXT=='GMP') {

            if (gmp_cmp($cp1->a, $cp2->a) == 0 && gmp_cmp($cp1->b, $cp2->b) == 0 && gmp_cmp($cp1->prime, $cp2->prime) == 0) {
                return 0;
            } else {
                return 1;
            }

        } else {
            throw new ErrorException("Please install GMP");
        }
    }

}
?>