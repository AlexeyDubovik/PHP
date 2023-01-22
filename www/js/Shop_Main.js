import { controlFromInput, controlToInput, controlFromSlider, controlToSlider, fillSlider, setToggleAccessible } from '/js/Components/DoubleRange.js';
import { fillRating } from '/js/Components/Rating.js';

const formSlider    = document.querySelector('#slider_form');
const fromSlider    = document.querySelector('#fromSlider');
const toSlider      = document.querySelector('#toSlider');
const fromInput     = document.querySelector('#fromInput');
const toInput       = document.querySelector('#toInput');
const SliderFormBTN = formSlider == null ? null : formSlider.querySelector("input[type=button]");
const OrderForm     = document.getElementById("Product_Order");
const Rating        = document.querySelectorAll(".rating");
const formSearcher  = document.getElementById("Product_Searcher");
const SearcheBTN    = formSearcher == null ? null : formSearcher.querySelector("input[type=button]");
const SearchField   = formSearcher == null ? null : formSearcher.querySelector("input[type=text]");
const formGroup     = document.getElementById("Group_form");
const GroupBTN      = formSearcher == null ? null : formGroup.querySelector("input[type=button]");

//
//functions
// 

function SubmitWhithInjector(form){
    if(form.id === "Group_form"){
        var chekBoxes = form.querySelectorAll("input[type=checkbox]");
        for(var checkbox of chekBoxes){
            if(checkbox.checked === false){
                //console.log(checkbox.checked);
                form.submit();
            }
        }
    }
    else{
        if(form.id !== "slider_form"){
            if(toSlider.value !== toSlider.max)
                form.appendChild(toSlider);
            if(fromSlider.value !== fromSlider.min)
                form.appendChild(fromSlider);
        }
        else{
            //console.log(SearchField.value);
            if(SearchField.value !== null && SearchField.value !== "")
                form.appendChild(SearchField);
        }
        form.submit();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    fillSlider(fromSlider, toSlider, toSlider);
    setToggleAccessible(toSlider);
    fromSlider.oninput    = () => controlFromSlider  (fromSlider, toSlider,  fromInput);
    toSlider.oninput      = () => controlToSlider    (fromSlider, toSlider,  toInput);
    fromInput.oninput     = () => controlFromInput   (fromSlider, fromInput, toInput, toSlider);
    toInput.oninput       = () => controlToInput     (toSlider,   fromInput, toInput, toSlider);
    SliderFormBTN.onclick = () => SubmitWhithInjector(formSlider);
    OrderForm.onchange    = () => SubmitWhithInjector(OrderForm);
    SearcheBTN.onclick    = () => SubmitWhithInjector(formSearcher);
    GroupBTN.onclick      = () => SubmitWhithInjector(formGroup);
    for (let Rate of Rating) {
        fillRating(Rate);
    }   
});
