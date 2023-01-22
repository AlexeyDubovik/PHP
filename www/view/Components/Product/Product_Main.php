<link rel="stylesheet" href="/css/Product_Main.css">
<?php if(isset($_CONTEXT["product"])) {
    $product = $_CONTEXT["product"]; ?>
    <div class="product" data-id="<?=$product['product_id']?>" >
        <div class="product_header">
            <div class="product_head_1">
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
            <nav class="prod-nav navbar navbar-expand-sm">
                <div class="prod-nav-collapse navbar-collapse">
                  <ul class="navbar-nav">
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="/shop/p<?=$product['product_id']?>">About</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="/shop/p<?=$product['product_id']?>/characteristics" style="pointer-events: none;">Сharacteristics</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="/shop/p<?=$product['product_id']?>/reviews">Reviews 
                        <span style="color: gray;">(<?=$product['votes']?>)</span>
                    </a>
                    </li>
                  </ul>
                </div>
            </nav>
        </div>
        <div class="tab-area">
            <?php include "Routes/Product_Router.php" ?>
        </div>
    </div>
<?php } else { ?>
    <div class="error text-danger">
        <?= $product_error; ?>
    </div>
<?php };?>
<script type="module" src="<?= (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . 
                                "://" . $_SERVER['HTTP_HOST'] . "/js/Product_Main.js";?>">
</script>
