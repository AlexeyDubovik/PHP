<?php
$part1 = "view/Components/Product/";
if(!isset($_CONTEXT['path_parts'][3])){
    $_CONTEXT['path_parts'][3] = "";
}
switch ($_CONTEXT['path_parts'][3]) {
    case '':
        include $part1 . 'Info.php';
        break;
    case 'reviews':
    case 'characterictics':
        include $part1 . "{$_CONTEXT['path_parts'][3]}.php";
        break;
    default:
        if(is_array($_CONTEXT['product']))
            include $part1 . 'Info.php';
        else
            include 'view/404.php';
        break;
}
?>
    