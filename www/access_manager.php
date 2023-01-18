<?php 
//
//Server ip Manager
//

// echo "<pre>"; print_r( $_SERVER );
// echo "ip = " . $_SERVER['REMOTE_ADDR'] . "<br>";
// $MAC = exec('getmac');
// echo "MAC = $MAC";

//
//File Manager
//

include "conf/Allowed_files.php";
$path = explode('?', urldecode($_SERVER['REQUEST_URI']))[0];
$filename = "." . $path;
if (is_file($filename)) {
    $format = get_format($filename);
    if (isset($_CONTEXT['auth_user']['rights']) && $_CONTEXT['auth_user']['rights'] === "admin") {
        if($format === "php"){
            include $filename;
            exit;
        }
    }
    else allowed_file_response($filename);
}

include "Services/UUID.php";
include "Services/dbms.php";
include "Services/GlobalFunction.php";

$_LOG_DIR = "../log/MySql-errors.log";
$_CONTEXT[ 'connection' ] = Connect_DB();
$_CONTEXT[ 'connection' ] ?? Redirect("/page500.html");
$_CONTEXT[ 'path'       ] = $path;
$_CONTEXT[ 'path_parts' ] = explode('/', $path);
$_CONTEXT[ 'Error_loger'] = Make_Loger();
$_CONTEXT[ 'user_roles' ] = Get_Users_Roles();
$_CONTEXT[ 'auth_user'  ] = false;
$_CONTEXT[ 'pass_form'  ] = false;
$_CONTEXT[ 'products'   ] = false;
$_CONTEXT[ 'auth_info'  ] = false;
$_CONTEXT[ 'reg_info'   ] = false;
$_DIALOG_INFO = false;

//
//~MiddleWare 
//

include "Middleware/session.php";
include "Middleware/auth.php";

//
//Controllers
//

if($_CONTEXT['path_parts'][1] === 'phpmyadmin' ){
    if(isset($_CONTEXT['auth_user']['rights']) && $_CONTEXT['auth_user']['rights'] === "admin" ){
        if(isset($_SESSION['auth_id'])){
            session_abort();
        }
        include "phpMyAdmin/index.php";
        exit;
    }
    else Redirect("/404");
}
else{
    $controller_file = "controllers/" . $_CONTEXT['path_parts'][1] . "_controller.php";
    if(is_file($controller_file)) include $controller_file;
    else include 'view/Layout.php';
}


