import {counter_handler} from "../js/Components/Counter.js";
const PriceHandler = document.querySelectorAll(".price_handler");
const OrderField   = document.querySelectorAll(".order_container");
const ProductCount = document.querySelector(".prod_count");
// prod_count
document.addEventListener("DOMContentLoaded", () => {
    var oreder_span = null;
    if(OrderField != null && OrderField[0] != null) {
        oreder_span = OrderField[0].querySelector("span");
        oreder_span.innerText = 0;
    }
    if(PriceHandler != null) 
        PriceHandler.forEach(item => {
            var counter = item.querySelector(".counter");
            var price   = item.querySelector(".price span");
            counter_handler(counter, price, oreder_span, ProductCount);
        });
})