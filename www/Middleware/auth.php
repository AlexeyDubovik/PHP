<?php
// Аутентификация
$chars = '`\'\"}';
if(isset($_POST['userlogin']) && empty($_POST['userpassw'])){
    $_CONTEXT['auth_info'] = "Empty Password";
}
else if(isset($_POST['userpassw']) && empty($_POST['userlogin'])) {
    $_CONTEXT['auth_info'] = "Empty Login";       
}
else if(isset($_POST['userlogin']) && isset($_POST['userpassw'])) {
    $replaced = preg_replace('/['.$chars.']+/',"", $_POST['userlogin']);
    $sql = "SELECT * FROM Users u WHERE u.`login` = ?";
    $res = SQL_Request($sql, [$replaced]);
    if($res){
        $salt = $res['salt'];
        $hash = md5($_POST['userpassw'] . $salt);
        //сравниваем с сохраненным хешем
        if($hash == $res['pass']){ //авторизация успешна
            $_SESSION['auth_id'] = $res['user_id'];
            $_CONTEXT['auth_info'] = true;
            Redirect('/', false);
        }
        else{ //пароль неправильный
            $_CONTEXT['auth_info'] = "Access Denied";
        }
    }
    else{
        $_CONTEXT['auth_info'] = "Access Restrict";
    }
}
else if(isset($_SESSION['auth_id'])){
    $sql = "SELECT * FROM Users u WHERE u.`user_id` = ?";
    $error = "";
    $res = SQL_Request($sql, [$_SESSION['auth_id']]);
    if(is_array($res)){
        $res['avatar'] = $res['avatar'] === null ? "default.png" : $res['avatar'];
        $_CONTEXT['auth_user'] = [
            'id'      => $res['user_id'], 
            'login'   => $res['login'], 
            'name'    => $res['name'], 
            'email'   => $res['email'], 
            'confirm' => $res['confirm'], 
            'reg_dt'  => $res['reg_dt'],
            'avatar'  => $res['avatar'],
            'rights'  => $res['role_id']
        ];
        $Layout_nav_auth = $res['name'];
    }
    else{
        $Layout_nav_auth = "error";
    }
}
else if(is_string($_CONTEXT['auth_info'])){  
    $view_data = [
        'login' => $_POST['userlogin']
    ];
}

// $salt = md5(random_bytes(16));
// $pass = md5('123' . $salt);
// $sql = "INSERT INTO Users VALUES(UUID(), 'admin', 'Root Administrator',
// '$salt', '$pass', 'admin@i.ua', '123456', CURRENT_TIMESTAMP)";
// try{
//     $connection->query($sql);
//     echo "INSERT OK";
// }
// catch(PDOException $ex){
//     echo $ex->getMessage();
// }
// try{
//     $connection->query( <<<SQL
//     CREATE TABLE Users(
//     `id`        CHAR(36)    NOT NULL PRIMARY KEY COMMENT 'UUID',
//     `login`     VARCHAR(64) NOT NULL,
//     `name`      VARCHAR(64) NULL,
//     `salt`      CHAR(32)    NOT NULL COMMENT 'random 128bit' ,
//     `pass`      CHAR(32)    NOT NULL COMMENT 'password hash',
//     `email`     VARCHAR(64) NOT NULL,
//     `confirm`   CHAR(6)     NULL     COMMENT 'email confirm code',
//     `reg_dt`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP
// ) ENGINE = InnoDB, DEFAULT CHARSET = UTF8
// SQL);
// echo "User OK";
// }
// catch(PDOException $ex){
//     echo $ex->getMessage();
// }
/*
Таблица пользователей
CREATE TABLE Users(
    `id`        CHAR(36)    NOT NULL PRIMARY KEY COMMENT 'UUID',
    `login`     VARCHAR(64) NOT NULL,
    `name`      VARCHAR(64) NULL,
    `salt`      CHAR(32)    NOT NULL COMMENT 'random 128bit' 
    `pass`      CHAR(32)    NOT NULL COMMENT 'password hash'
    `email`     VARCHAR(64) NOT NULL,
    `confirm`   CHAR(6)     NULL     COMMENT `email confirm code`
    `reg_dt`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB, DEFAULT CHARSET = UTF8
*/