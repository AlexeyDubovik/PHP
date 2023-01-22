<?php
    global $_CONTEXT;
    $filename = "." . $_CONTEXT['path'];
    if($_CONTEXT['path_parts'][1] === 'phpmyadmin' ){
        if(isset($_CONTEXT['auth_user']['rights']) && $_CONTEXT['auth_user']['rights'] === "admin") {
            if(isset($_SESSION['auth_id'])) session_abort();
            if(is_file($filename)){
                if(get_format($filename) === "php"){
                    include $filename;
                    exit;
                }
                else allowed_file_response($filename);
            }
            else{
                include "phpMyAdmin/index.php";
                exit;
            }
        }
        else Redirect("/404");
    }
?>