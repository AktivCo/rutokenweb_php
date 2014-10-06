<?php
/**
 * Plain Old PHP Object that stores the signature r,s for ECDSA
 *
 * @author Matej Danter
 */

class Signature implements SignatureInterface{

    protected $r;
    protected $s;

    public function  __construct($r, $s) {
        $this->r = $r;
        $this->s = $s;


    }


    public function getR(){
        return $this->r;
    }

    public function getS(){
        return $this->s;
    }
}
?>
