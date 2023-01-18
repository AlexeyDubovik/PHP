<div class="Products_list">
    <?php if (is_string($product_error)) { ?>
        <div class='text-center'>
            <p class='p-2 text-danger'>
                <?= $product_error ?>
            </p>
        </div>
    <?php } else if (is_array($_CONTEXT['products'])) {
        foreach ($_CONTEXT['products'] as $key => $product):
            include "view/Components/Shop/product_lite.php";
        endforeach; 
    } else { ?>
        <div class="Products_Empty">
            <h5 class="text-info">
                Products Empty
            </h5>
        </div>
    <?php }?>
</div>
