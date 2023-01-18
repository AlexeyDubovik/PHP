<link rel="stylesheet" href="css/Registrtion.css">
<div class="d-flex justify-content-center h-50 w-100 p-3">
    <form method="post" id="reg_form" class="reg-form" enctype="multipart/form-data">
        <div class="form-group mb-2">
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input id="reg_login"class="col form-control" type="text" name="user_login_Reg" placeholder="Login"
                value='<?= (isset($view_data['login'])) ? $view_data['login'] : "" ?>'/>
                <span id="reglogin" class="col-auto text-danger"> *</span>
            </div>
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input id="reg_name"class="form-control col" type="text" name="user_name_Reg" placeholder="Name"
                value='<?= (isset($view_data['name'])) ? $view_data['name'] : "" ?>'/>
                <span id="regname" class="col-auto text-danger">*</span>
            </div>
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input id="reg_pass"class="form-control col" type="password" name="user_pass_Reg" placeholder="Password"/>
                <span id="regpass" class="col-auto text-danger"></span>
            </div>
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input disabled id="reg_pass_2"class="form-control col" type="password" name="user_pass_Conf" placeholder="Confirm Password"/>
                <span id="regpass_2" class="col-auto text-danger"></span>
            </div>
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input id="reg_email"class="form-control col"type="text" name="user_Email_Reg" placeholder="Email" 
                required value='<?= (isset($view_data['email'])) ? $view_data['email'] : "" ?>'/>
                <span id="regemail" class="col-auto text-danger">*</span>   
            </div>
            <div class="row mb-2">
                <label for="" class="col-auto text-danger w-25"></label>
                <input class="form-control col" type="file"  id="avatar" name="avatar" accept="image/png, image/jpeg"/>
                <span  class="col-auto text-danger"></span>   
            </div>
        </div>
        <div class="column text-center mb-2">
            <small class="form-text text-muted ">Do not use any of these common illegal symbols in fields: </small>
            <small class="form-text text-muted">
                <span class="text-warning">}</span>, 
                <span class="text-warning">`</span>, 
                <span class="text-warning">'</span>, 
                <span class="text-warning">"</span>
            </small>
            <br>
            <small id="emailHelp" class="form-text text-muted ">
                Fields marked with 
                <span class="text-danger">*</span>
                are required 
            </small>
        </div>
        <?php if(is_string($_CONTEXT['reg_info'])) { echo "<div class='text-center'><p class='p-2 text-danger'>{$_CONTEXT['reg_info']}</p></div>";}?>
        <div class="text-center">
            <button disabled type="submit" class="btn btn-outline-info mb-2">Registrtion</button>
        </div>
    </form>
    <?php if(is_string($_DIALOG_INFO)) { include "Template/Modal_bootstrap.php"; }?>
    <script src="js/Registration.js"></script>
</div>
