<?php
//Одна из задач контроллера - разделить работы по методам запроса

//echo "Reg Controller";
switch (strtoupper($_SERVER['REQUEST_METHOD'])){
    case "GET"  :
        $view_data = [];
        if( isset( $_SESSION[ 'reg_error' ] ) ) {
            $_CONTEXT['reg_info'] = $_SESSION[ 'reg_error' ];
            $view_data = $_SESSION['data_form'];
            unset( $_SESSION[ 'reg_error' ]);
        }
        else if(isset( $_SESSION[ 'reg_ok' ])) {
            $_DIALOG_INFO = $_SESSION[ 'reg_ok' ];
            unset( $_SESSION[ 'reg_ok' ] ) ;
        }
        include 'view/Layout.php';
        break;
    case "POST" :
        include "Services/Reg.php";
        include 'view/Layout.php';
        //Redirect($_CONTEXT[ 'path_parts' ][1]);
        break;
}