<?php
// Регистрация
$chars = '`\'\"}';
@include_once "Services/send_email.php";
if(empty($_POST['user_login_Reg'])) {
    $_SESSION[ 'reg_error' ] = "Empty login" ;
}
else if(empty( $_POST['user_name_Reg'])) {
    $_SESSION[ 'reg_error' ] = "Empty User name" ;
}
else if(empty( $_POST['user_pass_Reg'])) {
    $_SESSION[ 'reg_error' ] = "Empty Password" ;
}
else if(empty($_POST['user_Email_Reg'])) {
    $_SESSION[ 'reg_error' ] = "Empty email" ;
}
else if($_POST['user_pass_Reg'] !== $_POST['user_pass_Conf']) {
    $_SESSION[ 'reg_error' ] = "Passwords mismatch";
} 
else if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $_POST['user_Email_Reg'])) {
    $_SESSION[ 'reg_error' ] = "Email is not valid!";
}
else if(!function_exists("send_email")){
    $_SESSION[ 'reg_error' ] = "include error";
}
else {
    $login = preg_replace('/['.$chars.']+/',"", $_POST['user_login_Reg']);
    $name  = preg_replace('/['.$chars.']+/',"", $_POST['user_name_Reg']);
    $email = preg_replace('/['.$chars.']+/',"", $_POST['user_Email_Reg']);
    $sql = "SELECT * FROM Users u WHERE u.`login` = ? OR u.`email` = ?";
    $res = SQL_Request($sql, [$login, $email]);
    if(is_array($res)){
        $_SESSION[ 'reg_error' ] = "Your login or email is already in use";
    }
    else if(is_string($res)){
        $_SESSION[ 'reg_error' ] = $res;
    }
    else {
        $avatar = null;
        if( isset( $_FILES['avatar'] ) ) { 
            if( $_FILES['avatar']['error'] == 0 && $_FILES['avatar']['size'] != 0 ) {
                // есть переданный файл
                $info = new SplFileInfo($_FILES['avatar']['name']);
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
                        $_SESSION[ 'reg_error' ] = "Invalid avatar format";
                        break;
                }
            }
        }
        $salt = md5(random_bytes(16));
        $pass = md5($_POST['user_pass_Conf'] . $salt);
        $confirm_code = bin2hex(random_bytes(3));
        $body = "<b>Hello  {$_POST['user_name_Reg']}</b><br>Type code <strong>{$confirm_code} </strong>";
        //отправить код 
        $res = send_email("bamboleo confirm", $_POST['user_Email_Reg'], $body);
        $sql = "INSERT INTO Users(`user_id`,`login`,`name`,`salt`,`pass`,`email`,`confirm`,`avatar`,`email_sent`) 
        VALUES(UUID(),?,?,'$salt','$pass',?,'$confirm_code',?,?)";
        $res = SQL_Request($sql, [ $login, $name, $email, $avatar, $res]);
        if(is_string($res)){
            $_SESSION[ 'reg_error' ] = $res;
        }
        else {
            if($avatar !== null){
                move_uploaded_file($_FILES['avatar']['tmp_name'], './avatars/' . $avatar);
            }
            $_SESSION[ 'reg_ok' ] = "New user created successfully";
            Redirect('/registration');
        }
    } 
}
if(!empty( $_SESSION[ 'reg_error' ])){  // были ошибки - сохраняем в сессии все введенные значения (кроме пароля)
    $_SESSION['data_form']= [
        'login' => $_POST['user_login_Reg'], 
        'name'  => $_POST['user_name_Reg'], 
        'email' => $_POST['user_Email_Reg']
    ];
}




