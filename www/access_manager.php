<?php 
//
//Server ip Manager
//

// echo "<pre>"; print_r( $_SERVER );
// echo "ip = " . $_SERVER['REMOTE_ADDR'] . "<br>";
// $MAC = exec('getmac');
// echo "MAC = $MAC";

include "Services/Allowed_files.php";
include "Services/UUID.php";
include "Services/dbms.php";
include "Services/GlobalFunction.php";

$path = explode('?', urldecode($_SERVER['REQUEST_URI']))[0];
$_LOG_DIR = "../log/MySql-errors.log";
$_CONTEXT[ 'connection' ] = Connect_DB();
$_CONTEXT[ 'connection' ] ?? Redirect("/page500.html");
$_CONTEXT[ 'path'       ] = $path;
$_CONTEXT[ 'path_parts' ] = explode('/', $path);
$_CONTEXT[ 'Error_loger'] = Make_Loger();
$_CONTEXT[ 'Errors'     ] = false;
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
//File Manager
//

include "Services/phpMyAdmin.php";
if(is_file("." . $path)) allowed_file_response("." . $path);

//
//Controllers
//

$controller_file = "controllers/" . $_CONTEXT['path_parts'][1] . "_controller.php";
if(is_file($controller_file)) include $controller_file;
else include 'view/Layout.php';



