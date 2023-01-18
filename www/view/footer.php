<footer class="border-top footer text-muted">
    <div class="FooterContainer">
    <?php
        echo "<b>This is a footer</b>";
        $someString = "(copy)";
        $currentYear = date("Y");
        $footer_arr[] = $someString;
        $footer_arr[] = $currentYear;
        echo "<br/>";
        echo stringForm($footer_arr);
        function stringForm( $input = []){
            $tmp = "";
            foreach($input as $val){
                $tmp .= " " . $val;
            }
            return $tmp;
        }
    ?>
    </div>
</footer>