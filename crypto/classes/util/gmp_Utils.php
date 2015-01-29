<?php
/**
 * The gmp extension in PHP does not implement certain necessary operations
 * for elliptic curve encryption
 * This class implements all neccessary static methods
 *
 */
class gmp_Utils {

    public static function gmp_mod2($n, $d) {
            $res = gmp_div_r($n, $d);
            if (gmp_cmp(0, $res) > 0) {
                $res = gmp_add($d, $res);
            }
            return gmp_strval($res);
    }

    public static function gmp_random($n) {
            $random = gmp_strval(gmp_random());
            $small_rand = rand();
            while (gmp_cmp($random, $n) > 0) {
                $random = gmp_div($random, $small_rand, GMP_ROUND_ZERO);
            }

            return gmp_strval($random);
    }

    public static function gmp_hexdec($hex) {
            $dec = gmp_strval(gmp_init($hex), 10);

            return $dec;
    }

    public static function gmp_dechex($dec) {
            $hex = gmp_strval(gmp_init($dec), 16);

            return $hex;
    }

}
?>