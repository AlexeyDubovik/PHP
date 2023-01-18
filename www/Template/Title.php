<?php	 
    switch($_CONTEXT['path_parts'][1]){
        case 'index': 
            $actualTitle = "Home";
            break;    
        case '404': 
            $actualTitle = "404";
            break; 
        case 'fundamentials': 
            $actualTitle = "Fundamentials";
            break;
        case 'basic': 
            $actualTitle = "Basic";
            break; 
        case 'formdata': 
            $actualTitle = "Form Data";
            break; 
        case 'database': 
            $actualTitle = "Data Base";
            break;  
        case 'Authorization': 
            $actualTitle = "Authorization";
            break;
        case 'Registration': 
            $actualTitle = "Registration";
            break;
        case 'profile': 
            $actualTitle = $_CONTEXT['path_parts'][2];
            break;                      
        default:
            $actualTitle = "Home";
            break;
    }
?> 
<title> <?php echo $actualTitle;?> </title> 