<?php

/**
 * This is the contract for the PublicKey portion of ECDSA.
 *
 * @author Matej Danter
 */
interface PublicKeyInterface {
    
    public function __construct(Point $generator, Point $point);

    public function GOST_verifies($hash, Signature $signature);

    public function getCurve();

    public function getGenerator();

    public function getPoint();

}
?>
