function ShowInfo(status, ProfileConteiner) {
    let div = document.createElement('div');
    let b = document.createElement('b');
    div.setAttribute('class', 'info');
    if (status != 'Success') {
        div.id = 'infoError';
    }
    b.innerText = status;
    div.append(b);
    ProfileConteiner.append(div);
    let calc = (status.length / 16 * 1000);
    let count = calc < 1000? 1000 : calc;
    setTimeout(e => {
        ProfileConteiner.removeChild(div);
    }, count);
}
function SAvatarUpload(ButtonAvatar) {
    ButtonAvatar.style.color = 'rgb(49, 80, 135)';
    ButtonAvatar.style.background = 'rgba(46,57,77,0.4)';
    ButtonAvatar.style.boxShadow = '0 5px 10px rgba(84, 108, 96, 0.5)';
}
function SAvatarChange(ButtonAvatar) {
    ButtonAvatar.style.color = '#1b6b43';
    ButtonAvatar.style.background = 'rgba(60,80,89,0.5)';
    ButtonAvatar.style.boxShadow = '0 0 40px rgba(84, 108, 96, 0.8)';
}
let fileTypes = ['image/jpeg', 'image/pjpeg', 'image/png']
function validFileType(file) {
    for (let i = 0; i < fileTypes.length; i++) {
        if (file.type === fileTypes[i])
            return true;
    }
    return false;
}
function Style_Insert_from_UserProfileField(ClassName){
    const cont = document.querySelector('.container');
    const Field = document.querySelectorAll(ClassName);
    var styleElem = document.getElementById('UserProfileFieldStyle_1');
    const theFirstChild = cont.firstChild;
    if(styleElem === null){
        //styleElem.remove();
        styleElem = document.createElement("style");
        styleElem.id = "UserProfileFieldStyle_1"
        styleElem.innerHTML = "";
    }
    var count = 1;
    Field.forEach((item)=>{
    let Field_Name = item.querySelector('.Field_Name');
    // console.log(item.getAttribute('class'));
    styleElem.innerHTML += `
    ${ClassName}:nth-child(${count}):after {
        width:  calc(100% - ${Field_Name.offsetWidth + 6}px);
        right: -1px;
    }`;
    count++;
    });
    cont.insertBefore(styleElem, theFirstChild);
}
export { ShowInfo, SAvatarUpload, SAvatarChange, validFileType, Style_Insert_from_UserProfileField};
