<div class="filter_field">
    <form id="Group_form" class="filter_form">
        <div class="Group_container">
            <?php if(isset( $view_data['categories_including_product'])) 
            foreach ($view_data['categories_including_product'] as $key => $value) { ?>
                <label>
                    <input class="form-check-input" type="checkbox" name="Filter_Group[<?=  $value['name'] ?>]" 
                    value="<?= $value['category_id'] ?>" 
                    <?php if (isset($view_data['filters']['Checked_Group']["{$value['name']}"])) 
                            echo 'checked';
                    ?>>
                    <b><?=  $value['name'] ?></b>
                    <i>(<?= $value['cnt'] ?>)</i>
                </label>
            <?php } else  { ?>
                <label>
                    <b>Empty categories </b>
                </label>
            <?php }; ?>
            <input type="button" class="btn btn-outline-success mt-2 btn_ok" value="OK">
        </div>
    </form>
    <form id="slider_form" class="filter_form">
        <div class="range_container">
            <div class="sliders_control" data-sliderColor="#C6C6C6" data-rangeColor="#25daa5">
                <input id="fromSlider" class="doubleRange" type="range" name="minprice"
                value='<?= $view_data['filters']['minprice']?>' min='<?= $view_data['minprice']?>' max='<?= $view_data['maxprice']?>'/>
                <input id="toSlider"   class="doubleRange" type="range" name="maxprice"
                value='<?= $view_data['filters']['maxprice']?>' min='<?= $view_data['minprice']?>' max='<?= $view_data['maxprice']?>'/>
            </div>
            <div class="form_control">
                <input class="form_control_container__time__input" type="number" id="fromInput" 
                value='<?= $view_data['filters']['minprice']?>' min='<?= $view_data['minprice']?>' max='<?= $view_data['maxprice']?>'/>
                <input class="form_control_container__time__input" type="number" id="toInput" 
                value='<?= $view_data['filters']['maxprice']?>' min='<?= $view_data['minprice']?>' max='<?= $view_data['maxprice']?>'/>
                <input type="button" class="btn btn-outline-success mb-2 btn_ok" value="OK">
            </div>
        </div>
    </form>
</div>