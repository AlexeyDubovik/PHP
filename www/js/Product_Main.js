import { fillRating, evFormHandler, setColor } from '/js/Components/Rating.js';
import { LikingHandler } from '/js/Components/Liked.js';

window.replyForm   = replyForm;
const Rating       = document.querySelectorAll(".rating");
const Form_Rating  = document.querySelectorAll(".form_rating");
const btnCart      = document.querySelector("#toCart");
const btnFeedback  = document.querySelector("#GiveFeedback");
const productEl    = document.querySelector(".product");
const Product_id   = productEl === null ? null : productEl.dataset.id;
const ProductCount = document.querySelector(".prod_count");
const Liking       = document.querySelectorAll(".estimate");
const Review       = document.querySelector(".review");


//
//functions
// 

function replyForm(e){
    var id = e.target.closest(".review").id;
    let modal   = document.querySelector("#modal_reply");
    let input   = document.querySelector("#reply_form .invisible input");
    if(input != null) input.value = id;
    let close   = modal.querySelector(".close");
    modal.style.display = "block";
    close.onclick       = (e) => modal.style.display = "none";
    modal.onclick       = (e) => {
        if(e.target.id != undefined && e.target.id == modal.id)
            modal.style.display = "none";
    }
}

function changeCartSVG(svg, container){
    var div = document.createElement("div");
    div.setAttribute("class", "success");
    div.innerText = "✓";
    svg.style.fill = "#198754";
    container.appendChild(div);
}

function changeBTN (){
    var text = btnCart.querySelectorAll('div')[1];
    changeCartSVG(
        btnCart.querySelector('svg'),
        btnCart.querySelectorAll("div")[0]
    );
    text.style.color = "#93b1d6";
    text.style.textDecoration = "underline";
    text.innerText = "In Cart";
}   

function checkCart(){
    fetch(window.location.href + `?checkcart`)
    .then(r => r.json())
    .then(j => {
        if(j.status === "redirect"){
            changeBTN();
            console.log('ok');
        }
    })
}

document.addEventListener("DOMContentLoaded", () => {
    for (let Rate of Rating) fillRating(Rate);
    if(Liking != null){
        Liking.forEach(item =>{
             LikingHandler(item, Review.id);
        })  
    }
    if(Form_Rating != null){
        for (let Rate of Form_Rating) {
            fillRating(Rate);
            Rate.onmousemove = (e) => {
                if(e.target.tagName === "svg" || e.target.tagName === "path"){
                    var data = evFormHandler(e);
                    setColor(Rate, data.RateNumber - 1, data.offsetColor);
                }
            }
            Rate.onclick = (e) => {
                if(e.target.tagName === "svg" || e.target.tagName === "path"){
                    var data = evFormHandler(e);
                    var input = Rate.querySelector(".rate_input");
                    input.value = (data.RateNumber - 1) + Number(data.offsetColor);
                    Form_Rating[0].dataset.ratevalue = input.value;
                }
            }
            Rate.onmouseleave = () => fillRating(Rate);
        }   
    }
    if(btnFeedback != null){
        let modal   = document.querySelector("#modal_review");
        let close   = modal.querySelector(".close");
        close.onclick        = (e) => modal.style.display = "none";
        btnFeedback.onclick  = (e) => modal.style.display = "block";
        modal.onclick        = (e) => {
            if(e.target.id != undefined && e.target.id == modal.id)
                modal.style.display = "none";
        }
    }
    if(btnCart != null){
        checkCart();
        btnCart.onclick = () => {
            var formData = new FormData();
            formData.append('product_id', Product_id);
            fetch(window.location.href, { method:"POST", body: formData})
            .then(r => r.json())
            .then(j => {
                if(j.status === "success"){
                    var number = Number(ProductCount.innerText);
                    number++;
                    if(number > 0){
                        ProductCount.innerText = number;
                        ProductCount.setAttribute('style','display:block;');
                    }
                    changeBTN();
                }
                else if(j.status === "redirect"){
                    var url = new URL(window.location.href);
                    document.location.href = `${url.origin}/cart`;
                }
                else{
                    console.log('error');
                }
                console.log(j[Product_id]);
            });
        }
    }
});
