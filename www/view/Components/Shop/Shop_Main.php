<link rel="stylesheet" href="/css/Shop_Main.css">
<link rel="stylesheet" href="/css/Components/DoubleRange.css">
<link rel="stylesheet" href="/css/Components/Pagination.css">
<div class="d-flex flex-row w-100">
    <?php include "view/Components/Shop/Filter.php" ?>
    <div class="Products_container">
        <?php include "view/Components/Shop/Product_header.php" ?>
        <?php if(!is_string($product_error)) { ?>
            <div class="d-flex flex-column justify-content-center text-center">
                <b>
                    Total: <?= $view_data[ 'paginator' ][ 'total' ] ?> position  
                    <?php if (isset($view_data['search'])){ echo 'from ' . '\''. $view_data['search'].'\'';}?>
                </b>
            </div>
        <?php }?>
        <?php include "view/Components/Shop/Products_list.php" ?>
        <?php include "view/Components/Shop/Products_paginator.php" ?>
    </div>  
</div>
<?php 
    if (isset($_CONTEXT['auth_user']['rights']) && 
        $_CONTEXT['auth_user']['rights'] === 
        $_CONTEXT['user_roles'][0]['id'] ){
        include "view/Components/Admin_Container.php";
    } 
?>
<script type="module" src="../js/Shop_Main.js"></script>