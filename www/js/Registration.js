document.addEventListener("DOMContentLoaded", () => {
    const Registration_form = document.querySelector("#reg_form");
    if(Registration_form !== null){
        const email_error      = "Email is incorrect";
        const pass_error       = "Do not mutch";
        const symbols_error    = "Do not use illegal symbols";
        const form_inputs_text = Registration_form.querySelectorAll('input[type="text"]');
        const form_inputs_pass = Registration_form.querySelectorAll('input[type="password"]');
        const form_submit      = Registration_form.querySelector('button[type="submit"]');
        const validateSymbols = (str) => {
            return String(str)
              .toLowerCase()
              .match(/^[a-zA-Z0-9_ ]+$/);
        }
        const validateEmail = (email) => {
            return String(email)
              .toLowerCase()
              .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
              );
        }
        const button_solver = () => {
            if( pass_confirmed    === true && 
                email_confirmed   === true && 
                symbols_confirmed === true &&
                text_inputs_filled_count === 0) {
                form_submit.disabled = false;  
            }
            else if(form_submit.disabled === false){
                form_submit.disabled = true;
            }
        }
        const span_init = (element) => {
            let str = element.id.replace('_', '');
            span = document.querySelector(`#${str}`);
        }
        var span = null;
        var pass_confirmed    = false;
        var email_confirmed   = false;
        var symbols_confirmed = false;
        var text_inputs_filled_count = form_inputs_text.length;
        form_inputs_text.forEach(element => {
            span_init(element);
            let length = element.value.length;
            if(length > 0){
                text_inputs_filled_count--; 
                span.innerText = "";
                if(text_inputs_filled_count === 0){
                    email_confirmed = true;
                    symbols_confirmed = true;
                    from_redirect = true;
                }
            }
            element.oninput = (e) => {
                span_init(element);
                if(element.value.length > 0){
                    if(element.id === "reg_email" && validateEmail(element.value)){
                        span.innerText = "";
                        email_confirmed = true;
                    }
                    else if(element.id === "reg_email" && !validateEmail(element.value)){
                        span.innerText = email_error;
                        email_confirmed = false;
                    }
                    else if(!validateSymbols(element.value)){
                        span.innerText = symbols_error;
                        symbols_confirmed = false;
                    }
                    else {
                        span.innerText = "";
                        symbols_confirmed = true;
                    }
                    // console.log(text_inputs_filled_count);
                    // console.log(symbols_confirmed);
                    // console.log(pass_confirmed);
                    // console.log(email_confirmed);
                    if((element.value.length === 1 &&
                        e.inputType !== "deleteContentForward" && 
                        e.inputType !== "deleteContentBackward" && ( 
                        e.inputType === 'insertText' && length === 0)) ||
                        e.inputType === "insertFromPaste" || (
                        e.inputType === undefined && length === 0)){
                        text_inputs_filled_count--;
                    }
                }
                else{
                    span.innerText = "*";
                    text_inputs_filled_count++;
                }
                length = element.value.length;
                button_solver();
            };
        });
        form_inputs_pass.forEach(element => {
            element.oninput = (e) => {
                span_init(form_inputs_pass[1]);
                if(form_inputs_pass[0].length > 0){
                    form_inputs_pass[1].disabled = false;
                }
                else if(form_inputs_pass[1].disabled = false){
                    form_inputs_pass[1].disabled = true;
                }
                if((element.value.length > 0 && 
                    form_inputs_pass[0].value) !== 
                    form_inputs_pass[1].value){
                    span.innerText = pass_error;
                    pass_confirmed = false;
                }
                else{
                    pass_confirmed = true;
                    span.innerText = "";
                }
                button_solver();
            };
        });
    }
});