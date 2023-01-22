<?php
$_CONTEXT['pass_form'] = false;
if(empty($_CONTEXT['path_parts'][2])){
    echo "Profile undefined";
    exit;
}
if(is_array($_CONTEXT['auth_user']) && $_CONTEXT['auth_user']['login'] == $_CONTEXT['path_parts'][2]){
    $_PROF_DATA = [
        'avatar'  => $_CONTEXT['auth_user']['avatar'],
        'login'   => $_CONTEXT['auth_user']['login'],
        'name'    => $_CONTEXT['auth_user']['name'],
        'email'   => $_CONTEXT['auth_user']['email'],
        'confirm' => $_CONTEXT['auth_user']['confirm'],
        'reg_dt'  => $_CONTEXT['auth_user']['reg_dt']
    ];
}
else{
    $sql = "SELECT u.* FROM Users u WHERE u.login = ?";
    $row = SQL_Request($sql, [$_CONTEXT['path_parts'][2]]);
    if(is_array($row)){
        $row['avatar'] = $row['avatar'] === null ? "default.png" : $row['avatar'];
        $_PROF_DATA = [
            'avatar' => $row['avatar'],
            'login'  => $row['login'],
            'name'   => $row['name'],
            'email'  => $row['email'],
            'reg_dt' => $row['reg_dt']
        ];
    }
    else{
        $_PROF_DATA = null;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_array($_CONTEXT['auth_user'])) {
        http_response_code(401);
        echo "Unauthorized";
        exit;
    } 
    else if(isset($_FILES['Avatar'])){
        if( $_FILES['Avatar']['error'] == 0 && $_FILES['Avatar']['size'] != 0 ) {
            $info = new SplFileInfo($_FILES['Avatar']['name']);
            $format = $info->getExtension();
            switch($format){
                case 'jpg': 
                case 'jpeg': 
                case 'png': 
                    do {
                        $avatar = bin2hex(random_bytes(3)) . "." . $format;
                    } while( file_exists( 'avatars/' . $avatar));
                    break;
                default: 
                    http_response_code(403);
                    echo "Invalid avatar format";
                    exit;
            }
            if(file_exists('avatars/' . $_CONTEXT['auth_user']['avatar']) && $_CONTEXT['auth_user']['avatar'] !== "default.png"){
                unlink('avatars/' . $_CONTEXT['auth_user']['avatar']);
            }
            $sql = "UPDATE Users u SET u.`avatar` = ? WHERE u.`user_id` = ?";
            $res = SQL_Request($sql, [ $avatar, $_CONTEXT['auth_user']['id']]);
            if(is_string($res)){
                http_response_code(500);
                echo $res;
                exit;
            }
            else {
                if($avatar !== null){
                    move_uploaded_file($_FILES['Avatar']['tmp_name'], './avatars/' . $avatar);
                }
                http_response_code(200);
                echo "Avatar update";
                exit;
            }
        }
        else{
            http_response_code(400);
            echo "Invalid request";
            exit;
        }
    }
    else if(isset($_SESSION['lastToken_passForm']) && $_POST['token_passForm'] === $_SESSION['lastToken_passForm']){
        //$_CONTEXT['pass_form'] = false;
        $_CONTEXT['pass_form'] = [];
        Redirect('/' . $_CONTEXT['path_parts'][1] . "/" . $_CONTEXT['path_parts'][2]);
    }
    else {
        if(isset($_POST['token_passForm'])){
            $_SESSION['lastToken_passForm'] = $_POST['token_passForm'];
            if (empty($_POST["OldPass"]) || empty($_POST["NewPass"]) || empty($_POST["ConfPass"])) {
                $_CONTEXT['pass_form'][3] = "Some Field Empty";
            } else if ($_POST["NewPass"] !== $_POST["ConfPass"]) {
                $_CONTEXT['pass_form'][2] = "Passwords don't  match";
            } else {
                $sql = "SELECT * FROM Users u WHERE u.`user_id` = ?";
                $res = SQL_Request($sql, [$_CONTEXT['auth_user']['id']]);
                if ($res) {
                    $salt = $res['salt'];
                    $hash = md5($_POST['OldPass'] . $salt);
                    if ($hash == $res['pass']) {
                        $sql = "UPDATE Users u SET u.`pass` = ? WHERE u.`user_id` = ?";
                        $hash = md5($_POST['ConfPass'] . $salt);
                        $res = SQL_Request($sql, [$hash, $_CONTEXT['auth_user']['id']]);
                        if (is_string($res)) {
                            $_CONTEXT['pass_form'][3] = $res;
                        } else {
                            $_CONTEXT['pass_form'][4] = "Changed";
                        }
                    } else {
                        $_CONTEXT['pass_form'][1] = "Access Denied";
                    }
                } else {
                    $_CONTEXT['pass_form'][1] = "Access Restrict";
                }
            }
        }
        else{
            $_CONTEXT['pass_form'] = false;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (!is_array($_CONTEXT['auth_user'])) {
        http_response_code(401);
        echo "Unauthorized";
        exit;
    } else {
        $body = file_get_contents("php://input");
        $data = json_decode($body, true);
        foreach ($data as $key => $value) {
            if (strlen($value) === 0) {
                http_response_code(400);
                echo "Bad request";
                exit;
            }
            $Tsql = [];
            $param = [];
            switch ($key) {
                case 'Email':
                    if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $data[$key])) {
                        http_response_code(403);
                        echo "Email is not valid!";
                        exit;
                    }
                    $sql = "SELECT * FROM Users u WHERE u.`email` = ?";
                    $res = SQL_Request($sql, [$value]);
                    if (is_array($res)) {
                        http_response_code(406);
                        echo "This email is already in use";
                        exit;
                    }
                    $Tsql[] = "UPDATE Users u SET u.`email` = ? WHERE u.`user_id` = ?";
                    $param[] = [$value, $_CONTEXT['auth_user']['id']];
                    break;
                case 'Name':
                    $Tsql[] = "UPDATE Users u SET u.`name` = ? WHERE u.`user_id` = ?";
                    $param[] = [$value, $_CONTEXT['auth_user']['id']];
                    break;
                case 'Login':
                    $sql = "SELECT * FROM Users u WHERE u.`login` = ?";
                    $res = SQL_Request($sql, [$value]);
                    if (is_array($res)) {
                        http_response_code(406);
                        echo "This login is already in use";
                        exit;
                    }
                    $Tsql[] = "UPDATE Users u SET u.`login` = ? WHERE u.`user_id` = ?";
                    $param[] = [$value, $_CONTEXT['auth_user']['id']];
                    break;
                default:
                    http_response_code(400);
                    echo "Bad request";
                    exit;
            }
            $res = SQL_Transaction_Request($Tsql, $param);
            if (is_string($res)) {
                http_response_code(500);
                echo "Internal Server " . $res;
                exit;
            } else {
                http_response_code(200);
                echo "OK";
                exit;
            }
        }
        exit;
    }
}
include 'view/Layout.php';
