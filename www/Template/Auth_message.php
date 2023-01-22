<div class="d-flex" style="min-height: 150px;">
    <div class="h1 align-self-center text-center w-100">
        You must 
        <a class="text-info" href="
            <?= (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . "://" . 
                $_SERVER['HTTP_HOST'] . "/authorization";?>">
            login
        </a>
    </div>
</div>