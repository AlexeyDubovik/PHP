<?php
function get_format($filename){
    $info = new SplFileInfo($filename);
    return $info->getExtension();
}
function allowed_file_response($filename){
    ob_clean();
    $format = get_format($filename);
    switch($format){
        case 'css': 
        case 'html': 
            $content_type = "text/$format" ; 
            break;
        case 'js': 
            $content_type = "application/x-javascript; charset=utf-8";
            break;
        case 'map': 
            $content_type = "application/octet-stream";
            break;
        case 'jpg': 
        case 'png': 
        case 'ico': 
        case 'gif': 
            $content_type = "image/$format";
            break;
        case 'svg' :
            $content_type = "image/svg+xml" ;
            break ;   
        default: 
            return false;
    }
    header("Content-Type: $content_type");
    readfile($filename);
    exit;
}
