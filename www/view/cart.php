<link rel="stylesheet" href="/css/cart.css">
<div class="cart_container">
    <div class="d-flex justify-content-center">
        <div class="cart_header">
            <h2>Cart</h2>
        </div>
    </div>
    <div class="cart_content">
        <?php 
            if(is_array($_CONTEXT['products']))
                foreach($_CONTEXT["products"] as $product)
                    include "view/Components/Cart/product.php";
            else { ?>
            <div>
                <span>Your Cart is Empty</span>
            </div>
        <?php }; ?>
    </div>
    <?php if(is_array($_CONTEXT['products'])) { ?>
        <div class="d-flex cart_foot">
            <div class='d-flex order_container' id="order_container">
                <div class="total">
                    <span></span> $
                </div>
                <div>
                    <button class="btn btn-success">Order</button>
                </div>
            </div>
        </div>
    <?php };?>
</div>
<script type="module" src="../js/Cart.js"></script>