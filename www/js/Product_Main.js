import { fillRating, evFormHandler, setColor } from '/js/Components/Rating.js';

const Rating   = document.querySelectorAll(".rating");
 
//const formSearcher  = document.getElementById("Product_Searcher");
//const SearcheBTN    = formSearcher.querySelector("input[type=button]");
//const SearchField   = formSearcher.querySelector("input[type=text]");

//
//functions
// 

document.addEventListener("DOMContentLoaded", () => {
    for (let form of Rating) {
        fillRating(form);
    }   
});
