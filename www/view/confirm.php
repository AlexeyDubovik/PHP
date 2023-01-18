<header>
    <link rel="stylesheet" href="/lib/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/confirm.css">
</header>
<body class="bg-dark">
    <?php if(is_string($_DIALOG_INFO)) { include "Template/Modal_bootstrap.php"; }?>
    <div class="d-flex justify-content-center align-items-center h-50 w-100 p-3">
        <form method="GET" id="auth_form">
            <div class="form-group mb-2">
                <?php if (empty($_CONTEXT['auth_user'])) { ?>
                    <input class="form-control"type="text" name="email" placeholder="Email"/>
                <?php } ?>
                <input class="form-control mb-2" type="text" name="code" placeholder="Code"/>
            </div>
            <?php  if(isset($_CONFIRM_INFO)) {echo "<p class='p-2 text-danger'>{$_CONFIRM_INFO}</p>";}?>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-info">Confirm Email</button>
            </div>
        </form>
    </div>
    <script src="/js/confirm.js"></script>
</body>