<div class="div_404">
    <?php
        $image_404 = "404";
        $file_name = '404';
        $format = "png";
        $directory_name = "icon";
        $short_path = "$directory_name/$file_name.$format";
        $from_root_path = $_SERVER['DOCUMENT_ROOT'] . "/$short_path";
        if(is_file($from_root_path)){
            //$image_404 = '<img class="img_404" src="data:image/jpg;base64,'.base64_encode(file_get_contents("$short_path ")).'" />';
            $image_404 = "<img class='img_404' src='$short_path' />";
        }
        echo $image_404;
    ?>
</div>