<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION["curt"][$_POST['prod_id']]))
        $_SESSION["curt"][$_POST['prod_id']] = $_POST['count']; 
    print_r($_SESSION["curt"][$_POST['prod_id']]);
    //print_r($_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_SESSION["curt"])){
        $_CONTEXT['products'] = [];
        foreach($_SESSION["curt"] as $product_id => $count){
            $sql = "SELECT * FROM `products`p WHERE p.`product_id` = ?";
            $res = SQL_Request($sql, [$product_id], PDO::FETCH_ASSOC);
            if (is_array($res)) {
                $res['count'] = $count;
                array_push($_CONTEXT['products'],
                [
                    'id'       => $res['product_id'],
                    'name'     => $res['name'],
                    'image'    => $res['image'],
                    'descr'    => $res['descr'],
                    'price'    => $res['price'],
                    'count'    => $res['count'],
                    'discount' => $res['discount'],
                ]);
            }
            else $product_error = $res;
        }
    }
    else{
        $_CONTEXT['products'] = false;
    }
    
    include 'view/Layout.php';
    //$_CONTEXT["curt"];
}
