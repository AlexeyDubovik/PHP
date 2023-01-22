<?php global $product; ?>
<div class="counter" data-prod_id="<?= $product['id']?>">
    <button class="counter_btn">
        <div class="counter_svg">
            <?php include "icon/minus.svg";?>
        </div>
    </button>
    <input class="counter_input form-control" type="number" style=" text-align: center;" value="<?= $product['count']; ?>">
    <button class="counter_btn">
        <div class="counter_svg">
            <?php include "icon/plus.svg";?>
        </div>
    </button>
</div>