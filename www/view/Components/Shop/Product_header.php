<div class="Product_Header">
    <form id="Product_Order" class="Product_Order">
        <select class="form-select form-select-sm bg-dark text-secondary" name="order">
            <option value="moment" <?= $view_data[ 'order' ] === "moment" ? 'selected' : '' ?>>By New</option>
            <option value="price"  <?= $view_data[ 'order' ] === "price"  ? 'selected' : '' ?>>By Price</option>
            <option value="rating" <?= $view_data[ 'order' ] === "rating" ? 'selected' : '' ?>>By Rating</option>
        </select>
    </form>
    <form id="Product_Searcher" class="Product_Searcher">
        <div class="form-group d-flex mb-2">
            <input type="text"   class="form-control mb-2" name='search' placeholder="Search..." 
            <?php if(isset($view_data['search'])) echo 'value=' . $view_data['search']?>> 
            <input type="button" class="btn btn-outline-info mb-2 btn_ok" value="OK">
        </div>
    </form>
</div>