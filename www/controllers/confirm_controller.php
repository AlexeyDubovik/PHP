<?php
if(empty($_CONTEXT)){
    echo 'Неправильный запуск';
    exit;
}
if(!isset($_GET['code'])){
    include "view/confirm.php";
    exit;
}
else if(strlen($_GET['code']) === 0){
    $_CONFIRM_INFO = 'Code Empty';
}
else if(isset($_GET['email'])){
    //$sql = "SELECT COUNT(u.id) FROM Users u WHERE u.email = ? AND u.confirm = ?";
    $sql = "SELECT u.confirm FROM Users u WHERE u.email = ?";
    $res = SQL_Request($sql,[$_GET['email']], PDO::FETCH_NUM);
    print_error($res);
    $db_code = $res[0];
    if(count($res) !== 1){
        $_CONFIRM_INFO = "Error: More than one user";
    }
    else if($db_code === null){
        $_CONFIRM_INFO = "Code already confirmed";
    }
    else if($db_code === $_GET['code']){
        $sql = "UPDATE Users u SET u.confirm = NULL WHERE u.email = ? AND u.confirm = ?";
        $res = SQL_Request($sql, [$_GET['email'], $_GET['code']]);
        print_error($res);
        $_CONFIRM_INFO = 'Email confirmed';
    }
    else{
        $_CONFIRM_INFO = "Wrong code";
    }
}
else if(strlen($_GET['code']) > 0 && !empty( $_CONTEXT['auth_user'])){
    $sql = "SELECT u.confirm FROM Users u WHERE u.`user_id` = '{$_CONTEXT['auth_user']['id']}'";  
    $res = SQL_Request($sql, [], PDO::FETCH_NUM);
    print_error($res);
    $db_code = $res[0];
    if($db_code === null){
        $_CONFIRM_INFO = 'Mail confirmed, no action required';
    }
    else if($db_code === $_GET['code']){
        $sql = "UPDATE Users u SET u.confirm = NULL WHERE u.`user_id` = '{$_CONTEXT['auth_user']['id']}'";
        $res = SQL_Request($sql, []);
        print_error($res);
        //$_CONFIRM_INFO = 'Mail confirmed';
        $_DIALOG_INFO = 'Mail confirmed';
        //Redirect('/confirm');
    }
    else{
        $_CONFIRM_INFO = "Wrong code";
    }
}
else if(empty( $_CONTEXT['auth_user'])){
    $_CONFIRM_INFO = "Log in to confirm your email";
}
include "view/confirm.php";
function print_error($res){
    global $_CONFIRM_INFO;
    if(is_string($res)){
        $_CONFIRM_INFO = $res;
        include "view/confirm.php";
        exit;
    }
}
?>