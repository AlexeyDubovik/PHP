import { Style_Insert_from_UserProfileField } from '/js/Components/Profile_Form.js';
document.addEventListener('DOMContentLoaded', () => {
    const Profile = document.querySelector('.Profile');
    Profile.style.visibility = "visible";
    Style_Insert_from_UserProfileField('.Profile_Field.User');
});
