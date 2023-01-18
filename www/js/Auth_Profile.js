import { ShowInfo, SAvatarUpload, SAvatarChange, validFileType, Style_Insert_from_UserProfileField } from '/js/Components/Profile_Form.js';
document.addEventListener('DOMContentLoaded', () => {
    Style_Insert_from_UserProfileField('.Profile_Field.Password');
    const ProfileConteiner = document.querySelector('#ProfileConteiner');
    //
    //password form 
    //
    const Path        = document.URL;
    const PassForm    = document.getElementById('PassForm');
    const FormControl = document.getElementById('PassFormControl');
    const FormShow    = document.getElementById('PassFormDisplay');
    const FormHidde   = document.getElementById('FormHidde');
    if(PassForm !== null && FormControl !== null && FormHidde !== null && FormShow !== null){
        const PassField = PassForm.querySelectorAll('.Password');
        const btnForm   = PassForm.querySelector('button[type="submit"]');
        const TokenForm = PassForm.querySelector('input[type="hidden"]');
        if(btnForm != null && TokenForm != null && PassField != null){
            btnForm.onclick = ()=>{
                TokenForm.value = Math.floor(Math.random() * (99999 - 10000 + 1) ) + 10000;
            }
            PassField.forEach((item)=>{
                var input = item.querySelector('.Field_Data');
                var control =  item.querySelector('.password-control');
                control.onclick = e => {
                    if (input.getAttribute('type') === 'password'){
                        e.target.classList.add('view');
                        input.setAttribute('type', 'text');
                    } 
                    else if(input.getAttribute('type') === 'text'){
                        e.target.classList.remove('view');
                        input.setAttribute('type', 'password');
                    }
                }
            });
            PassForm.style.display = FormControl.dataset.php;
            FormControl.style.display = FormControl.dataset.php === "none" ? "inline" : "none";
            FormHidde.onclick = e => {
                PassForm.style.display = "none";
                FormControl.style.display = "inline";
                //TokenForm.value = "";
            }
            FormShow.onclick = e => {
                PassForm.style.display = "inline";
                FormControl.style.display = "none";
            }
        }
    }

    //
    //user avatar logic
    //

    const name1 = document.querySelector("Name1");
    const name2 = document.querySelector("Name2");
    const UploadAvaTxt = name1 === null ? "" : name1.innerText;
    const CnahgeAvaTxt = name2 === null ? "" : name2.innerText;
    const ButtonAvaTxt = document.querySelector("Text");
    const pic          = document.getElementById('AvatarIMG');
    const avaBtn          = document.getElementById('avatar_Select_Button');
    const Error        = document.getElementById('avaError');
    const ButtonAvatar = document.getElementById('ButtonAvatar');
    if(ButtonAvaTxt !== null){
        ButtonAvaTxt.innerText = UploadAvaTxt;
    }
    if(avaBtn !== null){
        avaBtn.addEventListener('change', updateImageDisplay);
    }
    function updateImageDisplay() {
        var curFile = avaBtn.files[0];
        if (avaBtn.files.length === 0) {
            Error.style.display = "inline";
            Error.textContent = 'No files currently selected for upload';
        }
        else {
            if (validFileType(curFile)) {
                let saveSRC = pic.src;
                pic.src = window.URL.createObjectURL(curFile);
                const formData = new FormData();
                formData.append("Avatar", curFile);
                ButtonAvaTxt.innerText = CnahgeAvaTxt;
                avaBtn.setAttribute('type', 'button');
                ButtonAvatar.onclick = e => {
                    //console.log(e.target);
                    if(e.target.id === "avatar_Select_Button"){
                        fetch(Path, {
                            method: "POST", 
                            body: formData,
                        })
                        .then( r => { 
                            ButtonAvaTxt.innerText = UploadAvaTxt;
                            e.target.setAttribute('type', 'file');
                            ButtonAvatar.onclick = e => {
                                if(e.target.id === "avatar_Select_Button"){
                                    avaBtn.click();
                                }
                            }
                            if(r.status >= 200 && r.status < 300) { 
                                //r.text().then(console.log);
                                var avaLayout = document.getElementById("Avatar_Layout");
                                avaLayout.src = pic.src;
                                saveSRC = null;
                                ShowInfo('Success', ProfileConteiner);
                                SAvatarUpload(ButtonAvatar);
                            } 
                            else if(r.status >= 400 && r.status < 500) { 
                                r.text().then(t=>{
                                    pic.src = saveSRC;
                                    Error.style.display = "inline";
                                    Error.textContent = t;
                                });
                            } 
                            else {
                                r.text().then(t=>{
                                    pic.src = saveSRC;
                                    Error.style.display = "inline";
                                    Error.textContent = t;
                                });
                            }
                        } );
                    }
                }
            }
            else {
                Error.style.display = "inline";
                Error.textContent = 'Not a valid file type. ';
            }
        }
    }
    //
    //User Data change
    //
    for (let i = 1; i <= 3; i++) {
        let userData;
        if (i === 1) {
            userData = document.getElementById("Name");
        }
        if (i === 2) {
            userData = document.getElementById("Email");
        }
        if (i === 3) {
            userData = document.getElementById("Login");
        }
        userData.onclick = e => {
            e.target.setAttribute("contenteditable", true);
            e.target.savedValue = e.target.innerText;
        };
        userData.onkeydown = e => {
            if (e.code === 'Enter') {
                e.preventDefault();
                userData.blur();
            }
        }
        userData.onblur = e => {
            e.target.removeAttribute("contenteditable");
            if (e.target.savedValue != e.target.innerText) {
                var json_str = `{"${e.target.id}" : "${e.target.innerText}"}`;
                console.log(Path);
                fetch(Path,{ 
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: json_str
                })
                .then( r => { 
                    console.log(r.status);
                    if(r.status >= 200 && r.status < 300) { 
                        r.text().then(t =>{ShowInfo("Success", ProfileConteiner)});
                    } 
                    else if(r.status >= 400 && r.status < 500) { 
                        r.text().then(t =>{ShowInfo(t, ProfileConteiner)});
                        e.target.innerText = e.target.savedValue;
                    } 
                    else {
                        r.text().then(t =>{ShowInfo(t, ProfileConteiner)});
                    }
                } ) ;
            }
        };
    }
});