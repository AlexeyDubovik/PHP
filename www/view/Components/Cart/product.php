<?php global $product;?>
<div class="select_product" data-prod_id="<?= $product['id']?>">
    <div class="d-flex flex-column">
        <div class="d-flex ">
            <div class="elm">
                <a class="m-2" href="../shop/p<?= $product['id']?>"> 
                    <img src="../images/<?= $product['image']?>" alt="">
                </a>
            </div>
            <div class="elm">
                <a href="../shop/p<?= $product['id']?>">
                    <h5><?= $product['name']?></h5>
                </a>
                <div class="sp_descr">
                    <span><?= $product['descr']?></span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="d-flex price_handler">
                <div class="elm price">
                    <span><?= round($product['price'], 3)?></span> ₴
                </div>
                <div class="elm p_control">
                    <?php include "Template/counter.php"?>
                </div>
            </div>
        </div>
    </div>
</div>