<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 1/03/2016
 * Time: 10:59 AM
 */


//unset($_SESSION['username']);
//unset($_SESSION['user_id']);
//unset($_SESSION['access_token']);
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'',time()-86400,'/');
}
session_destroy();

header("Location: sign-in.php?logout=1");exit;