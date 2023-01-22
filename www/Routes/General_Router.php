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
        include "view/unit.html";
        break;
    default:
        include 'view/404.php';
        break;
}
?>
    
