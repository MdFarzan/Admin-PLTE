<?php

/* 
    auth.php
    contains authentication related function
*/

// to check authentication before visiting any page which required credentials
function verify_session_auth(){
    session_start();

    if(!isset($_SESSION['ADMIN_LOGGED_IN']))
        header("Location: index.php");

}

// to check auth on sign in page
function verify_auth($db){

    session_start();

    if(isset($_SESSION['ADMIN_LOGGED_IN']))
        header("Location: dashboard.php");

    
    else{

        if($db == null)
            die("<strong>verify_auth()</strong> takes db connection, null given!");

        if(isset($_COOKIE['AUTH_TOKEN'])){
            $token = $_COOKIE['AUTH_TOKEN'];

            $sql = "SELECT * FROM admin_auth WHERE auth_token = '$token'";

            $data = $db->query($sql);
            $data = $data->fetch_assoc();

            $session_data = [
                "ADMIN_LOGGED_IN" => true,
                "USER_ID" => $data['id'],
                "USER_EMAIL" => $data['email']
        ];

        set_session_auth($session_data);
        header("Location: dashboard.php");
        }

    }        
}

// to set session auth
function set_session_auth($data = null){
    if($data == null || is_array($data) == false)
        die("In <strong>set_session_auth()</strong>, associative array expected as parameter!");

    session_start();

    foreach($data as $key => $val){
        $_SESSION[$key] = $val;
    }
      
}

// similar to logout
function end_auth(){
    session_destroy();

    if(isset($_COOKIE["AUTH_TOKEN"]))
        setcookie("AUTH_TOKEN", null, time()-86400, "/");
}

