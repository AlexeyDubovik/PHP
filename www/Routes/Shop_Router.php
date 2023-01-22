<?php
    if(isset($_CONTEXT['path_parts'][2]))
        include "view/Components/Product/Product_Main.php";
    else include "view/Components/Shop/Shop_Main.php";
?>