<?php
switch ($_CONTEXT['path_parts'][1]) {
    case '':
        include 'view/index.php';
        break;
    case 'index':
    case 'fundamentials':
    case 'basic':
    case 'formdata':
    case 'database':
    case 'authorization':
    case 'registration':
    case 'profile':
    case 'shop':
    case 'confirm':
    case 'cart':
        include "view/{$_CONTEXT['path_parts'][1]}.php";
        break;
    case 'test':
        if(isset($_CONTEXT['auth_user']['rights']) && $_CONTEXT['auth_user']['rights'] == 'admin')
            include "view/unit.html";
        else
            include 'view/404.php';     
        break;
    default:
        include 'view/404.php';
        break;
}
?>
    
