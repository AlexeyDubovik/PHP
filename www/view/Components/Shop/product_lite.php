<div class="product" data-id="<?=$product['product_id']?>" >
    <a href="/shop/p<?=$product['product_id']?>">
        <div class="img-container" >
            <img class="product_image" src="/images/<?= $product['image'] ?>" />
        </div>
        <div class="container_prod_name">
            <h4><?= $product['name'] ?></h4>
        </div>
        <div class="container_prod_descr text-secondary">
            <h5><?= $product['descr'] ?></h5>
        </div>
    </a>
    <span class="price"> <?= round($product['price'], 3) . " ₴" ?></span>
    <?php if( ! empty( $product['discount'] ) ) : ?>
        (<i><?= $product['discount'] ?></i>)
    <?php endif ?>
    <div class="rating-area">
        <div class="rating" data-rateValue="<?= $product['rating'] ?>">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <label class="rate" data-rateNumber="<?=$i?>">
                    <?php include "icon/Star.svg";?>
                </label>
            <?php };?>
        </div>
        <div class="rateinfo">
            <span class="text-info" style="margin:1px 5px;">(<?= $product['rating'] ?>)</span>
            <span class="text-warning" style="margin:2px;"><?= $product['votes'] ?> votes</span>
        </div>
    </div>
    <u style="text-decoration:none;">Add: <?= date( "H:i d.m.y", strtotime( $product['add_dt'] ) ) ?></u>
</div>