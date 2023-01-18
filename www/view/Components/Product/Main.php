<link rel="stylesheet" href="/css/Product_Main.css">
<?php $product = $_CONTEXT["product"]?>
<div class="product" data-id="<?=$product['product_id']?>" >
    <div class="container_prod_name">
        <h4><?= $product['name'] ?></h4>
    </div>
    <div class="product_head_2">
        <div class="rating-area">
            <div class="rating" data-rateValue="<?= $product['rating'] ?>">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <label class="rate" data-rateNumber="<?=$i?>">
                        <?php include "icon/Star.svg";?>
                    </label>
                <?php };?>
            </div>
           <div class="rating_info">
                <span class="text-info" style="margin:1px 5px;">(<?= $product['rating'] ?>)</span>
                <span class="text-warning" style="margin:2px;"><?= $product['votes'] ?> votes</span>
           </div>
        </div>
        <u style="text-decoration:none;">Add: <?= date( "H:i d.m.y", strtotime( $product['add_dt'] ) ) ?></u>
    </div>
    
    <div class="tab-area">
        <div class="product_info">
            <div class="p-2 product_left">
                <div class="img-container" >
                    <img class="product_image" src="/images/<?= $product['image'] ?>" />
                </div>
                <div class="container_prod_descr text-secondary">
                    <h5><?= $product['descr'] ?></h5>
                </div>
            </div>
            <div class="p-2 product_right">
                <div class="p-2 trade">
                    <div class="price_area">
                        <span class="m-1 price"> <?= round($product['price'], 3) . " ₴" ?></span>
                        <?php if( ! empty( $product['discount'] ) ) : ?>
                            (<i><?= $product['discount'] ?></i>)
                        <?php endif ?>
                    </div>
                    <div class="m-2 buttons d-flex">
                        <button class="m-1 btn btn-outline-success d-flex">
                            <div class="basket" style="width:50px">
                                <?php include "icon/basket.svg"?>
                            </div>
                            <div style="margin:auto;">
                                Buy
                            </div>
                        </button>
                        <button class="m-1 btn btn-outline-info">Buy Credit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="../js/Product_Main.js"></script>
