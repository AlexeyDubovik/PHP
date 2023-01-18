<?php
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false){
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

function Make_Loger(){
    return function ($message) {
        global $_LOG_DIR;
        $message = "[" . date("Y-m-d H:i:s") . "] [" . $message . "]";
        if (!is_file($_LOG_DIR)) {
            file_put_contents($_LOG_DIR, $message);
        }
        else {
            error_log($message . "\n", 3, $_LOG_DIR);
        }
        return error_log($message . "\n", 3, $_LOG_DIR);
    };
}

function SQL_Request($sql, $param, $int = PDO::FETCH_ASSOC, $fetchAll = false){
    global $_CONTEXT;
    if(empty($_CONTEXT)){
        return "CONTEXT error: Please contact the administrator of this website.";
    }
    try{
        $stmt = $_CONTEXT['connection']->prepare($sql);
        $stmt->execute($param);
        if($fetchAll === true){
            return $stmt->fetchAll($int);
        }
        return $stmt->fetch($int);
    }
    catch(PDOException $ex){
        $_CONTEXT['Error_loger']($ex->getMessage());
        return "DB error: Please contact the administrator of this website.";
    }
}
function SQL_Transaction_Request($Tsql=["SQL"], $param = [[null]], $int = PDO::FETCH_ASSOC){
    global $_CONTEXT;
    if(empty($_CONTEXT)){
        return "CONTEXT error: Please contact the administrator of this website.";
    }
    try{
        $_CONTEXT['connection']->beginTransaction();
        foreach($Tsql as $key => $sql){
            $stmt = $_CONTEXT['connection']->prepare($sql);
            $stmt->execute($param[$key]);
        }
        return $_CONTEXT['connection']->commit();
    }
    catch(PDOException $ex){
        $_CONTEXT['Error_loger']($ex->getMessage());
        $_CONTEXT['connection']->rollBack();
        return "DB error: Please contact the administrator of this website.";
    }
}
function Get_Users_Roles(){
    return SQL_Request("SELECT * FROM `user_roles`", [], PDO::FETCH_ASSOC, true);    
}