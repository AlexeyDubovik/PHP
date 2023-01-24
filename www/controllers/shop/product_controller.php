<?php
$prod_id = substr($_CONTEXT['path_parts'][2], 1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        if (isset($_SESSION["curt"][$_POST['product_id']])) {
            echo json_encode(array('status' => "redirect", $_POST['product_id'] => "already in cart"));
        } else {
            $_SESSION["curt"][$_POST['product_id']] = 1;
            echo json_encode(array('status' => "success", $_POST['product_id'] => "add to cart"));
        }
    }
    if(isset($_CONTEXT["path_parts"][3]) &&
        $_CONTEXT["path_parts"][3] === "reviews" &&
        isset($_POST['reaction']) &&
        isset($_POST['review_id'])
    ){
        if(isset($_CONTEXT["auth_user"]['id']) && $_CONTEXT["auth_user"]['confirm'] === null){
            $sql = "SELECT * FROM `liking` l WHERE l.`user_id` = ? AND l.`review_id` = ?";
            $res = SQL_Request($sql, [$_CONTEXT['auth_user']['id'], $_POST['review_id']]);
            if(is_array($res)){
                echo json_encode(array('status' => "found"));
            }
            else{
                $sql = "INSERT INTO liking( 
                    `liking_id`, 
                    `review_id`,
                    `user_id`, 
                    `reaction` ) 
                    VALUES(UUID(), ?, ?, ?)";
                $params = [
                    $_POST['review_id'],
                    $_CONTEXT['auth_user']['id'],
                    $_POST['reaction']
                ];
                $res = SQL_Request($sql, $params);
                if (is_string($res)) {
                    echo json_encode(array('status' => $res ));
                } else {
                    echo json_encode(array('status' => "success", 'reaction' => $_POST['reaction']));
                }
            }
        }
        else{
            echo json_encode(array('status' => "forbidden"));
        }
    }

    //
    //Review
    //

    if(isset($_CONTEXT["path_parts"][3]) && 
    $_CONTEXT["path_parts"][3] === "reviews" &&
    isset($_POST['rating']) && 
    isset($_POST['advantages']) && 
    isset($_POST['disadvantages']) && 
    isset($_POST['text'])){
        if (isset($_CONTEXT['auth_user']['id']) && $_CONTEXT['auth_user']['confirm'] === null) {
            $sql = "INSERT INTO review( 
            `review_id`, 
            `product_id`,
            `user_id`, 
            `rating`,
            `advantages`,
            `disadvantages`,
            `text` ) 
            VALUES( UUID(), ?, ?, ?, ?, ?,? )";
            $params = [
                $prod_id,
                $_CONTEXT['auth_user']['id'],
                $_POST['rating'] ?? 0.0,
                $_POST['advantages'] ?? null,
                $_POST['disadvantages'] ?? null,
                $_POST['text']
            ];
            $res = SQL_Request($sql, $params);
            if (is_string($res)) {
                $_SESSION['Form_Errors'] = $res;
            } 
        }
        else{
            $_SESSION['Form_Errors'] = "forbidden";
        }
        $path = "/";
        $count = count($_CONTEXT["path_parts"]);
        for ($i = 1; $i < $count; $i++){
            $path .= ($_CONTEXT["path_parts"][$i]);
            if($i != $count - 1) $path .= "/";
        }
        Redirect($path);
    }

    //
    //Reply
    //

    if(isset($_CONTEXT["path_parts"][3]) &&
        $_CONTEXT["path_parts"][3] === "reviews" &&
        isset($_POST['review_id']) &&
        isset($_POST['reply_text'])
    ) {
        if (isset($_CONTEXT['auth_user']['id']) && $_CONTEXT['confirmed'] === null) {
            $sql = "INSERT INTO reply( 
                `reply_id`,
                `review_id`, 
                `user_id`, 
                `text`) 
                VALUES( UUID(), ?, ?, ?)";
                $params = [
                    $_POST['review_id'],
                    $_CONTEXT['auth_user']['id'],
                    $_POST['reply_text']
                ];
                $res = SQL_Request($sql, $params);
                if (is_string($res)) {
                    $_SESSION['Form_Errors'] = $res;
                }
        }
        else{
            $_SESSION['Form_Errors'] = 'forbidden'; 
        }
        $path = "/";
        for ($i = 1; $i < count($_CONTEXT["path_parts"]); $i++){
            $path .= ($_CONTEXT["path_parts"][$i] . "/");
        }
        Redirect($path);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['checkcart'])) {
        if (isset($_SESSION["curt"][$prod_id])) {
            echo json_encode(array('status' => "redirect"));
        } else {
            echo json_encode(array('status' => "stay"));
        }
        exit;
    } else {
        //
        //Product
        //
    
        $sql = "SELECT * FROM `products`p WHERE p.`product_id` = ?";
        $res = SQL_Request($sql, [$prod_id], PDO::FETCH_ASSOC);
        if (is_array($res))
            $_CONTEXT['product'] = $res;
        else
            $product_error = $res;

        //
        //Review Get
        //

        if(isset($_CONTEXT["path_parts"][3]) && 
            $_CONTEXT["path_parts"][3] === "reviews"){
            $sql = "SELECT rv.*, u.name as user_name, u.role_id as rights  
                    FROM `review` rv 
                    JOIN `users`u    ON rv.`user_id`    = u.`user_id` 
                    WHERE rv.`product_id` = ?
                    ORDER BY rv.date";
            $res = SQL_Request($sql, [$prod_id], PDO::FETCH_ASSOC, true);
            if (is_array($res)){
                if(count($res) > 0){
                    $_CONTEXT['reviews'] = $res;
                    foreach ($_CONTEXT['reviews'] as $key => $value) {
                        $sql = "SELECT r.*, u.name as user_name, u.role_id as rights  
                            FROM `reply` r 
                            JOIN `users`u ON r.`user_id` = u.`user_id` 
                            WHERE r.`review_id` = ?
                            ORDER BY r.date";
                        $res_2 = SQL_Request($sql, [$value['review_id']], PDO::FETCH_ASSOC, true);
                        $_CONTEXT['reviews'][$key]['replys'] = $res_2;
                    }
                }
            }
            else
                $review_error = $res;
        }
        include 'view/Layout.php';
    }
}