<?php
/**
 * Created by PhpStorm.
 * User: fugong
 * Date: 1/03/2016
 * Time: 10:09 AM
 */
session_start();
require_once('config.php');
function std_class_object_to_array($stdclassobject)
{
    $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
    foreach ($_array as $key => $value) {
        $value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        $array[$key] = $value;
    }
    return $array;
}
function login($username,$password)
{
    $url = NEW_DP_URL."index.php/TokenPassport/login";
    $ch = curl_init($url);

    //设置post方式提交
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $post_data = array(

        "username" => $username,
        "password" => $password,
        "user_type" => 'admin',
        "grant_type" => 'password',
        "client_id" => 'iiyumclient',
        "client_secret" => 'iiyumpass'
    );

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

    $curl_result = curl_exec($ch);

    $output_array = std_class_object_to_array(json_decode($curl_result, true));

    curl_close($ch);

    return $output_array;
}

$username = $_POST['username'];
$password = $_POST['password'];
$token = login($username,$password);
if(!$token['access_token']){
    header("Location:sign-in.php?error=1");exit;
}
//if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = $token['user_id'];
//}
//if(!isset($_SESSION['access_token'])){
    $_SESSION['access_token'] = $token['access_token'];
//}
//$user_id = $_SESSION['user_id'];
//$access_token = $_SESSION['access_token'];
$_SESSION['username'] = $username;
header("Location:index.php");exit;