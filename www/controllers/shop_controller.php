<?php
$product_admin_error = false;
$product_error       = false;
$category_error      = false;
$select_part = "*";
$join_part   = ""; 
$where_part  = "";
$order_part  = "ORDER BY";
$filters = [];
$sql = "";
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {    
    //Redirect("/shop");
}
if( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    if(isset($_POST['product_id'])){
        print_r($_POST);
        $sql = "SELECT * FROM `products`p WHERE p.`product_id` = ?";
        $res = SQL_Request( $sql, [$_POST['product_id']]);
        if(is_array($res)){
            $sql = "INSERT INTO product_category( `id`, `product_id`, `category_id` ) VALUES( UUID(), ?, ?) ";
            $res = SQL_Request( $sql, [$_POST['product_id'], $_POST['category_id']]);
            if(is_string($res)) $_SESSION['error_add_category_to_product'] = $res;
        }   
        else $_SESSION['error_add_category_to_product'] = "Empty Product";
    }
    else if(isset($_POST['category_name'])){
        $sql = "SELECT * FROM `product_categories`p WHERE p.`name` = ?";
        $res = SQL_Request( $sql, [$_POST['category_name']]);
        if(is_array($res)){
            $_SESSION['product_form_error'] = "Category already has" ;
        }
        else{
            $sql = "INSERT INTO product_categories( `category_id`, `name` ) VALUES( UUID(), ?) ";
            $res = SQL_Request( $sql, [$_POST['category_name']]);
            if(is_string($res)) $_SESSION['category_form_error'] = $res;
        }
    }
    else{
        if( isset( $_FILES[ 'image' ] ) ) {
            if( $_FILES[ 'image' ][ 'error' ] == 0  && $_FILES[ 'image' ][ 'size' ] > 0 ) {  
                $dot_position = strrpos( $_FILES['image']['name'], '.' ) ;  // strRpos ~ lastIndexOf
                if( $dot_position == -1 ) {  // нет расширения у файла
                    $_SESSION['product_form_error'] = "File without type not supported" ;
                }
                else {
                    $extension = substr( $_FILES[ 'image' ][ 'name' ], $dot_position ) ;  // расширение файла (с точкой ".png")
                    if( ! array_search( $extension, [ '.jpg', '.png', '.jpeg', '.svg' ] ) ) {
                        $_SESSION['product_form_error'] = "File extension '{$extension}' not supported" ;
                    }
                    else {
                        $image_path = 'images/' ;
                        do {
                            $image_name = bin2hex( random_bytes(8) ) . $extension ;
                        } while( file_exists( $image_path . $image_name ) ) ;
                        if( ! move_uploaded_file( $_FILES[ 'image' ][ 'tmp_name' ], $image_path . $image_name ) ) {
                            $_SESSION['product_form_error'] = "File (image) uploading error" ;
                        }
                    }
                }
            }
            else {   
                $_SESSION['product_form_error'] = "File error or file empty" ;
            }
        }
        else {   
            $_SESSION['product_form_error'] = "Image field exist" ;
        }
        if( empty($_SESSION['product_form_error'] )) {
            if( empty( $_POST[ 'name' ] )  || $_POST[ 'name' ] === "") {
                $_SESSION['product_form_error'] = "Empty name" ;
            }
            else if( empty( $_POST[ 'price' ] ) || $_POST[ 'price' ] === "") {
                $_SESSION['product_form_error'] = "Empty price" ;
            }
            $sql = "SELECT * FROM Products p WHERE p.`name` = ?" ;
            $res = SQL_Request( $sql, [ $_POST[ 'name' ]]);
            if(is_array($res)){
                $_SESSION['product_form_error'] = "Product already has" ;
            }
            else{
                $sql = "INSERT INTO Products( `product_id`, `name`,`descr`, `price`,`discount`,`image` ) 
                VALUES( UUID(), ?, ?, ?, ?, ? ) ";
                $params = [
                    $_POST[ 'name' ],
                    $_POST[ 'descr' ] ?? null,
                    $_POST[ 'price' ],
                    $_POST[ 'discount' ] ?? null,
                    $image_name
                ] ;
                $res = SQL_Request( $sql, $params);
                if(is_string($res)){
                    $_SESSION['product_form_error'] = $res;
                }
            }
        }
    }
    if( !isset( $_SESSION['product_form_error'] ) ) 
        $_DIALOG_INFO = "Add 1 Product";
    else if(!isset( $_SESSION['category_form_error'] ))
        $_DIALOG_INFO = "Add 1 Category";
    Redirect("/shop");
} 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && count($_CONTEXT['path_parts']) === 2) {
    //print_r($_GET);
    if (isset($_SESSION['category_form_error'])) {
        $category_error = $_SESSION['category_form_error'];
        unset($_SESSION['category_form_error']);
    }
    if (isset($_SESSION['product_form_error'])) {
        $product_admin_error = $_SESSION['product_form_error'];
        unset($_SESSION['product_form_error']);
    }
    if(isset($_SESSION['error_add_category_to_product'])){
        $view_data['error']['prod_add_category'] = $_SESSION['error_add_category_to_product'];
        unset($_SESSION['error_add_category_to_product']);
    }

    //
    //Rating
    //

    if (isset($_GET['rating']) && isset($_GET['product_id'])) {
        $sql = "SELECT * FROM `products` p WHERE p.`product_id` = ?";
        $res = SQL_Request($sql, [$_GET['product_id']]);
        if (is_array($res)) {
            $sql = "UPDATE `products` p SET p.`votes` = ?, p.`rating` = ? WHERE p.`product_id` = ?";
            $res['rating'] = ($res['votes'] * $res['rating'] + $_GET['rating']) / ($res['votes'] + 1);
            $res['votes'] += 1;
            $res = SQL_Request($sql, [$res['votes'], $res['rating'], $res['product_id']]);
            //else $product_error = $res;
        } else  $view_data['error']['update_rating'] = $res;
    }

    //
    // Order & Sort
    //

    if (isset($_GET['sort']))
        $sort_part = $_GET['sort'];
    else
        $sort_part = "DESC";

    if (isset($_GET['order']))
        $view_data['order'] = $_GET['order'];
    else
        $view_data['order'] = "moment";
    switch ($view_data['order']) {
        case "price":
            $order_part .= ' p.`price` ';
            break;
        case "rating":
            $order_part .= ' p.`rating`';
            break;
        default:
            $order_part .= ' p.`add_dt`';
    }

    //
    // Max Min prices
    //

    $sql = "SELECT MIN(p.price), MAX(p.price) FROM Products p";
    $res = SQL_Request($sql, [], PDO::FETCH_NUM);
    if (is_array($res)) {
        $view_data['minprice'] = round($res[0], 3);
        $view_data['maxprice'] = round($res[1], 3);
        $filters  ['minprice'] = $view_data['minprice'];
        $filters  ['maxprice'] = $view_data['maxprice'];
    } else
        $product_error = $res;

    //
    //Categories
    //

    $sql = "SELECT g.category_id, MAX(g.name) AS name, COUNT(p.category_id) AS cnt 
    FROM `product_categories` g 
    JOIN product_category p ON g.category_id=p.category_id GROUP BY 1" ;
    $res = SQL_Request($sql, [], PDO::FETCH_ASSOC, true);
    if(is_array($res)){
        $view_data['categories_including_product'] = $res;
    }
     
    $sql = "SELECT * FROM product_categories" ;
    $res = SQL_Request($sql, [], PDO::FETCH_ASSOC, true);
    if(is_array($res)){
        $view_data['categoryies'] = $res;
    }

    //
    // Search & filters
    //

    if (isset($_GET['search']) || isset($_GET['minprice']) || isset($_GET['maxprice']) || isset($_GET['Filter_Group'])) {
        $where_part = " WHERE";
        if (isset($_GET['minprice']) && is_numeric($_GET['minprice'])) {
            $where_part .= " p.price >= {$_GET['minprice']}";
            $filters['minprice'] = $_GET['minprice'];
        }
        if (isset($_GET['maxprice']) && is_numeric($_GET['maxprice'])) {
            $where_part .= (($where_part === " WHERE") ? " " : " AND ") . " p.price <= {$_GET['maxprice']}";
            $filters['maxprice'] = $_GET['maxprice'];
        }
        if (isset($_GET['search'])) {
            $fragment = $_CONTEXT['connection']->quote($_GET['search']);
            $where_part .= (($where_part === " WHERE") ? " " : " AND ") . " INSTR( p.name, $fragment ) OR INSTR( p.descr, $fragment ) ";
            $view_data['search'] = $_GET['search'];
        }
        if(isset($_GET['Filter_Group']) && count($_GET['Filter_Group']) != 
        count($view_data['categories_including_product'])){
            $select_part = "p.*, pcs.name as `grp_name`";
            $join_part = "JOIN product_category   pc  ON pc.product_id   = p.product_id 
                          JOIN product_categories pcs ON pcs.category_id = pc.category_id ";
            $arr[ 'id' ]   = [] ;
            $filters[ 'Checked_Group' ] = $_GET['Filter_Group'] ;
            foreach( $_GET['Filter_Group'] as $k => $v ) {
                $arr[ 'id' ][] = $v;
            }
            if( count( $arr[ 'id' ] ) > 0 ) {  
                $where_part .=  
                    ( ($where_part == " WHERE") ? " " : " AND " )
                . "pcs.category_id IN ( '" . implode( "','", $arr[ 'id' ] ) . "' ) " ;
            }
        }
    }
    $view_data['filters'] = $filters;

    //
    // Total and pagination
    //

    $sql = "SELECT COUNT(p.product_id) FROM Products p {$join_part} {$where_part} ";
    $res = SQL_Request($sql, [], PDO::FETCH_NUM);
    if (is_array($res)) {
        $total = $res[0];
        $perpage = 4;
        $lastpage = ceil($total / $perpage);
        if ($lastpage < 1)
            $lastpage = 1;
        if (isset($_GET['page']))
            $page = intval($_GET['page']);
        else
            $page = 1;
        if ($page < 1)
            $page = 1;
        if ($page > $lastpage)
            $page = $lastpage;
        $skip = ($page - 1) * $perpage;
        $view_data['paginator'] = [
            'page' => $page,
            'perpage' => $perpage,
            'lastpage' => $lastpage,
            'total' => $total
        ];
    } else{
        $product_error = $res;
    }
        
    //
    // General Request Products
    //

    $sql = "SELECT {$select_part} FROM `products` p {$join_part} {$where_part} {$order_part} {$sort_part} LIMIT {$skip}, {$perpage}";
    //echo $sql;
    $res = SQL_Request($sql, [], PDO::FETCH_ASSOC, true);
    //print_r($res);
    if (is_array($res)) $_CONTEXT['products'] = $res;
    else $product_error = $res;
    include 'view/Layout.php';
}
else if($_SERVER['REQUEST_METHOD'] === 'GET' && count($_CONTEXT['path_parts']) === 3) {
    //print_r($_GET);
    $sql = "SELECT * FROM `products`p WHERE p.`product_id` = ?";
    $prod_id = $_GET['p'];
    $res = SQL_Request($sql, [$prod_id], PDO::FETCH_ASSOC);
    if (is_array($res)) $_CONTEXT['product'] = $res;
    else $product_error = $res;
    include 'view/Layout.php';
}

