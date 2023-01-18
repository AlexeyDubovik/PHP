<?php if ($_PROF_DATA == null) { Redirect('/404');}?>
<link rel="stylesheet" href="../../css/profile.css">
<div class="container-custom">
    <div id="@User!.ID" class=".container-lg Profile">
        <h1 style="text-align:center;"><?php echo $_PROF_DATA['login']?></h1>
        <div id="ProfileConteiner" class="ProfileRow">
            <div class="container-sm Avatar_Container" style='display:flex; flex-direction:column; max-width: 200px;'>
                <div style="position:relative;">
                    <div class="container-sm" style='padding-top:15px; display:flex;flex-direction:column;'>
                        <img id="AvatarIMG" class="Profile_Avatar" src="../../avatars/<?php echo $_PROF_DATA['avatar']?>" />
                        <p id="avaError" style="color:red;display:none;"></p>
                        <?php if(is_array($_CONTEXT['auth_user']) && $_CONTEXT['auth_user']['login'] == $_CONTEXT['path_parts'][2]){?>
                        <div style="text-align:center">
                            <Name1 style="display:none">Upload Avatar</Name1>
                            <Name2 style="display:none">Change Avatar</Name2>
                            <label id="ButtonAvatar" class="custom-file-upload" style='margin:auto;'>
                                <input type="file" id="avatar_Select_Button" class="AvaFileBtn" name="Avatar" accept="image/*" />
                                <Text></Text>
                            </label>
                        </div>
                        <?php };?>
                    </div>
                </div>
            </div>
            <div class="container-sm" style='display:flex; flex-direction:column; padding-bottom:1.5em; max-width: 300px;'>
                <div class="Profile_table">
                    <div class="Profile_Field User">
                        <i class="Field_Name" >Registration date: </i>
                        <i class="Field_Data" ><?php echo $_PROF_DATA['reg_dt']?></i>
                    </div>
                    <div class="Profile_Field User">
                        <i class="Field_Name" >Login: </i>
                        <i class="Field_Data" id="Login" name="Login"><?php echo $_PROF_DATA['login']?></i>
                    </div>
                    <div class="Profile_Field User">
                        <i class="Field_Name" >Name: </i>
                        <i class="Field_Data" id="Name"  name="Name"><?php echo $_PROF_DATA['name']?></i>
                    </div>
                    <div class="Profile_Field User">
                        <i class="Field_Name" >Email: </i>
                        <i class="Field_Data" id="Email" name="Email"><?php echo $_PROF_DATA['email']?></i>
                        <?php if(!empty($_CONTEXT['auth_user']['confirm']) && $_CONTEXT['auth_user']['confirm'] !== null){?>
                            <br>
                            <i style="color:brown;">* Email not confirmed</i>
                            <br>
                            <a style="color:green;" href="/confirm">Link to confirm</a>
                        <?php };?>
                    </div>
                </div>
                <?php if(is_array($_CONTEXT['auth_user'])){?>
                    <div id="PassFormControl" class="BtnField" style="text-align:center;" 
                        data-php="<?php if (is_array($_CONTEXT['pass_form'])) {echo "inline";} else {echo "none";};?>">
                        <button id="PassFormDisplay" class="CustomButton">Show Password Form</button>
                    </div>
                    <form id="PassForm" class="User_PassForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="token_passForm"  />
                        <br>
                        <div class="Profile_table">
                            <div class="Profile_Field Password">
                                <i class="Field_Name" >Current Password: </i>
                                <input class="Field_Data" type="password" name="OldPass" />
                                <span class="password-control"></span>
                                <?php if(isset($_CONTEXT['pass_form'][1])){?>
                                    <span class="text-danger">
                                        <?php echo "*" . $_CONTEXT['pass_form'][1];?>
                                    </span>
                                <?php };?>
                            </div>
                            <div class="Profile_Field Password">
                                <i class="Field_Name" >New Password: </i>
                                <input class="Field_Data" type="password" name="NewPass"  />
                                <span class="password-control"></span>
                            </div>
                            <div class="Profile_Field Password">
                                <i class="Field_Name" >Confirm Password: </i>
                                <input class="Field_Data" type="password" name="ConfPass" />
                                <span class="password-control"></span>
                                <?php if(isset($_CONTEXT['pass_form'][2])){?>
                                    <span class="text-danger">
                                        <?php echo "*" . $_CONTEXT['pass_form'][2];?>
                                    </span>
                                <?php };?>
                            </div>
                        </div>
                        <?php if(isset($_CONTEXT['pass_form'][3])){?>
                            <div class="text-danger" style="text-align: center;">
                                <?php echo "*" . $_CONTEXT['pass_form'][3];?>
                            </div>
                        <?php };?>
                        <?php if(isset($_CONTEXT['pass_form'][4])){?>
                            <div class="color-green" style="text-align: center;">
                                <?php echo $_CONTEXT['pass_form'][4];?>
                            </div>
                        <?php };?>
                        <div class="BtnField" style="text-align: center;">
                            <button type="submit" class="CustomButton">Change Password</button>
                            <button id="FormHidde" type="button" class="CustomButton">Hide</button>
                        </div>
                    </form>
                <?php };?>
            </div>
        </div>
    </div>
</div>
<?php if(is_array($_CONTEXT['auth_user'])){?>
    <script type="module" src="../../js/Auth_Profile.js"></script>
<?php };?>
<script type="module" src="../../js/Profile.js"></script>


