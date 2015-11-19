<?
session_start();
require_once("crypto/token.php");
$_SESSION[$_GET['tlogin']]= token_random();
echo  $_SESSION[$_GET['tlogin']];
?>