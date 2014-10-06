<?php

/**
 * This is the contract for describing a signature used in ECDSA.
 *
 * @author Matej Danter
 */
interface SignatureInterface {
    public function __construct($r, $s);

    public function getR();

    public function getS();
}
?>
