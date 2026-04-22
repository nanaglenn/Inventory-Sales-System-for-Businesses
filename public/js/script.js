/**
 * Created by Glenn on 30/05/2019.
 */
function passwordMatchCheck(){
    if(document.getElementById('password').value !== document.getElementById('password-confirm').value){
        alert("Password and Confirm password field values do not match.");
    }else {
        document.getElementById('add-user-form').submit()
    }
}

function changePasswordMatchCheck(){
    if(document.getElementById('new-password').value !== document.getElementById('confirm-new-password').value){
        alert("Password and Confirm password field values do not match.");
    }else {
        submitEditUser();
    }
}