document.addEventListener("DOMContentLoaded", ()=>{
    const toggle = document.querySelector(".navbar-toggler");
    const menu   = document.querySelector(".navbar-collapse");
    toggle.style.boxShadow = "none";
    toggle.style.transition = ("0.5s");
    toggle.onmouseover = () =>{
        toggle.focus();
        toggle.style.transform = "scaleY(1.2)";  
        toggle.style.setProperty("-webkit-filter", "drop-shadow(0.1rem 0.1rem 0.1rem black)");
    }
    toggle.onmouseout = () =>{
        toggle.blur();
        toggle.style.transform = "scaleY(1)";  
        toggle.style.setProperty("-webkit-filter", "drop-shadow(0.1rem 0.1rem 0.1rem grey)");
    }
    toggle.onclick = (event) => {
        event.preventDefault();
        if( menu.style.display === "" || 
            menu.style.display === "none") 
            menu.style.display = "flex";
        else menu.style.display = "none";
    }
    const modal = document.querySelector('#exampleModal');
    if(modal !== null){
        var modal_childs = modal.querySelectorAll('button');
        modal_childs.forEach(element => {
            element.onclick = ()=> {
                modal.style.display = "none";
                var url = new URL(document.URL);
                window.location.replace(url.origin + "/authorization");
            };
        });
    }
});

