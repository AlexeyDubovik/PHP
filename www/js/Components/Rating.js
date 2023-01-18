async function fillRating(RatingForm){
    var ratingValueSTR = RatingForm.dataset.ratevalue;
    var RateNumber     = Number(ratingValueSTR.split('.')[0].replace(/\D+/g,""));
    var offsetColor    = Number(ratingValueSTR) - RateNumber;
    setColor(RatingForm, RateNumber, offsetColor.toFixed(1));
}
function calcOffset(svg, mousePosX){
    var width      = svg.clientWidth - 3;
    var distance   = svg.getBoundingClientRect().left;
    var differance = (mousePosX - distance); 
    var total      = (differance / width);
    return total;
}
function setColor(form, RateNumber, offsetColor){
    var labelElement = form.querySelectorAll(".rate");
    for (let i = 0; i < labelElement.length; i++) {
        var path = labelElement[i].querySelector("path");
        if(i === RateNumber){
            path.setAttribute('fill', `url(#G_${offsetColor})`);
        }
        else if(i > RateNumber){
            path.setAttribute('fill', `url(#G_0.0)`);
        }
        else{
            path.setAttribute('fill', `url(#G_1.0)`);
        }
    }
}
function evFormHandler(event){
    var offsetColor = 0;
    var RateNumber  = 0;
    if(event.target.tagName === "svg"){
        RateNumber = event.target.parentElement.dataset.ratenumber;
        offsetColor = calcOffset( event.target, event.clientX);
    }
    else if(event.target.tagName === "path"){
        RateNumber = event.target.parentElement.parentElement.dataset.ratenumber;
        offsetColor = calcOffset( event.target.parentElement, event.clientX);
    }
    if(Number(offsetColor) >= 1) offsetColor = "1.0";
    else if(offsetColor < 0) offsetColor = "0.0";
    else offsetColor = offsetColor.toFixed(1);
    return { offsetColor, RateNumber};
}
export{fillRating, calcOffset, setColor, evFormHandler};