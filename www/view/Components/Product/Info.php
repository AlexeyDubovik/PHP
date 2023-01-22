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
                <button class="m-1 btn btn-outline-success d-flex align-items-center" id="toCart">
                    <div class="on_btn_cart cart">
                        <?php include "icon/cart.svg"?>
                    </div>
                    <div>
                        Buy
                    </div>
                </button>
                <button class="m-1 btn btn-outline-info">Buy Credit</button>
            </div>
        </div>
    </div>
</div>