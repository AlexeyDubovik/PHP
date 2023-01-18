<div class="Products-Shop">
    <h1 class="shop_name" style="color: aquamarine;">Privoz</h1>
    <div>
        <?php include "Routes/Shop_Router.php" ?>
    </div>
    <?php 
        if (isset($_CONTEXT['auth_user']['rights']) && 
            $_CONTEXT['auth_user']['rights'] === 
            $_CONTEXT['user_roles'][0]['id'] ){
            include "view/Components/Admin_Container.php";
        } 
    ?>
</div>

