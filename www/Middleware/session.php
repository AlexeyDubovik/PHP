<?php
//session_name("session_without_cookie");
session_start();
$session_life_time = 1440;
if(isset($_GET['logout'])) {
    unset($_SESSION['auth_access']);
    unset($_SESSION['auth_id']);
    Redirect('/', false);
}
if(isset($_SESSION['auth_access'])) {
    //echo time() - $_SESSION['auth_access'];
    if((time() - $_SESSION['auth_access']) > $session_life_time ){
        unset($_SESSION['auth_access']);
        unset($_SESSION['auth_id']);
        //session_destroy();   
    }
    else if(isset($_SESSION['auth_id'])){
        $_SESSION['auth_access'] = time();  
    }
}
else if(isset($_SESSION['auth_id'])){
    $_SESSION['auth_access'] = time();  
}