<?php
/**
 * This is the contract for implementing CurveFp (EC prime finite-field).
 *
 * @author Matej Danter
 */
interface CurveFpInterface {
        //constructor that sets up the instance variables
        public function  __construct($prime, $a, $b);

        public function contains($x,$y);

        public function getA();

        public function getB();

        public function getPrime();

        public static function cmp(CurveFp $cp1, CurveFp $cp2);

}
?>
