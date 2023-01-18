<link rel="stylesheet" href="/css/admin_form.css">
<div class="Admin_Container">
    <h1 class="text-center text-info">Admin Form</h1>
    <div class="d-flex justify-content-center">
        <form method="POST" id="Product_form" class="Admin_form" enctype="multipart/form-data">
            <h5 class="text-info">Add Product</h5>
            <div class="form-group mb-2">
                <input type="file" name="image" accept="image/png" class="form-control mb-2"/>
                <input type="text"   class="form-control mb-2" name="name" placeholder="Name" />
                <input type="number" class="form-control mb-2" name="price"  placeholder="Price"/>
                <input type="number" class="form-control mb-2" name="discount" placeholder="Discount" />
                <textarea name="descr" class="form-control mb-2" placeholder="Description" ></textarea>
            </div>
            <div class="text-center m-2">
                <button type="submit" class="btn btn-outline-info">Add</button>
                <button type="submit" class="btn btn-outline-info">Update</button>
            </div>
            <?php if (is_string($product_admin_error)) { ?>
                <div class='text-center'>
                    <p class='p-2 text-danger'>
                        <?= $product_admin_error; ?>
                    </p>
                </div>
            <?php } ; ?>
        </form>
        <div class="d-flex flex-column">
            <form method="POST" id="Category_form" class="Admin_form">
                <h5 class="text-info">Add Category To Shop</h5>
                <div class="form-group mb-2">
                    <input type="text" class="form-control mb-2" name="category_name" placeholder="Name" />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info mb-2">Add</button>
                </div>
                <?php if (is_string($category_error)) { ?>
                    <div class='text-center'>
                        <p class='p-2 text-danger'>
                            <?= $category_error; ?>
                        </p>
                    </div>
                <?php } ; ?>
            </form>
            <form method="POST" id="Product_Category_Add" class="Admin_form" enctype="multipart/form-data">
                <h5 class="text-info">Add Category To Product</h5>
                <div class="form-group mb-2">
                    <select name="category_id" class="form-select form-select mb-2" >
                    <?php if(isset( $view_data['categoryies'])) foreach ($view_data['categoryies'] as $key => $value) { ?>
                        <option value="<?= $value['category_id'] ?>"><?= $value['name'] ?></option>
                    <?php }; ?>
                    </select>
                    <input type="text" class="form-control mb-2" name="product_id" placeholder="product_id" />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-info mb-2">Add</button>
                </div>
                <?php if (isset($view_data['error']['prod_add_category'])) { ?>
                    <div class='text-center'>
                        <p class='p-2 text-danger'>
                            <?= $view_data['error']['prod_add_category']; ?>
                        </p>
                    </div>
                <?php } ; ?>
            </form>
        </div>
    </div>
</div>