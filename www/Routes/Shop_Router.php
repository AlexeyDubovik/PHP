<?php
    if(isset($_CONTEXT['path_parts'][2]))
        include "view/Components/Product/Main.php";
    else include "view/Components/Shop/Main.php";
?>