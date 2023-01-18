<div class="d-flex justify-content-center align-items-center h-50 w-100 p-3">
    <form method="post" id="auth_form">
        <div class="form-group mb-2">
            <input class="form-control"type="text" name="userlogin" placeholder="Login" 
            value='<?= (isset($view_data['login'])) ? $view_data['login'] : "" ?>'/>
            <small class="form-text text-muted">Do not use any of these common illegal symbols in login input:</small>
            <small class="form-text text-muted">
                <span class="text-warning">}</span>, 
                <span class="text-warning">`</span>, 
                <span class="text-warning">'</span>, 
                <span class="text-warning">"</span>
            </small>
            <input class="form-control mb-2" type="password" name="userpassw" placeholder="Password"/>
        </div>
        <?php  if(is_string($_CONTEXT['auth_info'])) {echo "<p class='p-2 text-danger'>{$_CONTEXT['auth_info']}</p>";}?>
        <button type="submit" class="btn btn-outline-info mb-2">Log in</button>
        <a class="btn btn-outline-info mb-2" href="/registration">Registration</a>
    </form>
</div>
