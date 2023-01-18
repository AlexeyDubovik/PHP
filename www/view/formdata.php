<h2>
    Формы. Данные форм.
</h2>
<div style="position: relative; ">
    <form action="" method="GET" >
        <input type="text" name="str" placeholder="Send GET:">
        <button>Send GET</button>
    </form>
    <form action="" method="POST">
        <input type="text" name="strP" placeholder="Send POST:">
        <button>Send POST</button>
    </form>
    <form enctype="multipart/form-data" method="POST">
        <input type="file" name="formfile" placeholder="Send FILE">
        <br>
        <input nametype="descr" value="A file" placeholder="Enter description:">
        <button>Send File</button>
    </form>
    <p>$_GET:     <?php print_r($_GET)?></p>
    <p>$_POST:    <?php print_r($_POST)?></p>
    <p>$_REQUEST: <?php print_r($_REQUEST)?></p>
    <p>$_FILES:   <?php print_r($_FILES)?></p>
    <?php 
        $style = "style='top:10vh; text-align:center;'";
        $cancel_btn = "<button id='cancel' type='reset'>Cancel</button>";
        if(isset ($_FILES['formfile'])) {
            if($_FILES['formfile']['error'] === 0 ) {
                if($_FILES['formfile']['size'] > 0 ) {
                    $info = new SplFileInfo($_FILES['formfile']['name']);
                    switch($info->getExtension()){
                        case 'jpg': 
                        case 'png': 
                            move_uploaded_file($_FILES['formfile']['tmp_name'], './uploads/' . $_FILES['formfile']['name']);
                            //echo "<script>alert('Sucess upload')</script>";
                            echo "<dialog open id='favDialog' $style><p>Sucess upload!</p>$cancel_btn</dialog>";
                        break;
                        default: 
                            echo "<dialog open id='favDialog' $style><p>Invalid formats</p>$cancel_btn</dialog>";
                    }
                }
            }
            else {
                echo "<dialog open id='favDialog' $style><p>Error upload!</p>$cancel_btn</dialog>";
            }
        }
    ?>
</div>
<script>
    (function() {
      var favDialog = document.getElementById('favDialog');
      var cancelButton = document.getElementById('cancel');
      if(favDialog !== null && cancelButton !== null){
        setTimeout(()=>{ favDialog.close() }, 3000);
        cancelButton.addEventListener('click', () => { favDialog.close() });
      }
    })();
</script>