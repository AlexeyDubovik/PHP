const event = new InputEvent('input', {
    bubbles: true,
    cancelable: true,
});

function counter_handler(counter, span, order_span, ProductCount){
    const buttons = counter.querySelectorAll("button");
    const input   = counter.querySelector("input");
    const value   = Number(span.innerText);
    const prod_id = counter.dataset.prod_id;
    var   init    = true; 
    order_span.innerText = Number(order_span.innerText) + (value * Number(input.value));
    buttons[0].onclick = minus(input, ProductCount);
    buttons[1].onclick = plus(input, ProductCount);
    input.oninput = input_change(buttons[0], span, order_span, value, prod_id, init);
    input.dispatchEvent(event);
}

function minus(input, ProductCount){
    return (e)=>{
        if(input.value !== "" && input.value > 1) {
            input.value--;
            var tmp = Number(ProductCount.innerText);
            ProductCount.innerText = tmp - 1;
            console.log(tmp);
            input.dispatchEvent(event);
        } 
    }
}

function plus(input, ProductCount){
    return (e)=> {
        if(input.value !== "") {
            input.value++;
            var tmp = Number(ProductCount.innerText);
            ProductCount.innerText = tmp + 1;
            console.log(tmp);
            input.dispatchEvent(event);
        } 
    }
}

function input_change(btn, span, order_span, value, prod_id,init){
    return (e)=> {
        var number = Number(e.target.value);
        var total  = Number(order_span.innerText);
        if(e.inputType ==='deleteContentBackward') e.target.value = 1;
        if(number < 1) {
            e.target.value = 1;
            number = 1;
        }
        var price_before = Number(span.innerText);
        if(price_before != (value * number) && !init) send_count_product(prod_id, number);
        span.innerText = value * number;
        if(!init) order_span.innerText = (total - price_before) + (value * number);
        change_color(number, btn);
        if(init) init = false;
    }
}

function send_count_product(prod_id, number){
    var formData = new FormData();
    formData.append('prod_id', prod_id);
    formData.append('count', number);
    fetch(window.location.href, { method:"POST", body: formData})
    .then(r => r.text())
    .then(t => {
        console.log(t);
    });
}
function change_color(number, btn){
    var svg = btn.querySelector("svg");
    if(number <= 1) {
        svg.style.stroke = "grey";
        svg.style.fill = "grey";
    }
    if(number > 1 && svg.style.fill === "grey"){
        svg.style.stroke = "aquamarine";
        svg.style.fill = "aquamarine";
    }
}
export {counter_handler, minus, plus, change_color}

