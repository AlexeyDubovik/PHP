document.addEventListener("DOMContentLoaded", ()=>{
    const modal = document.querySelector('#exampleModal');
    if(modal !== null){
        var modal_childs = modal.querySelectorAll('button');
        modal_childs.forEach(element => {
            element.onclick = ()=> {
                modal.style.display = "none";
                var url = new URL(document.URL);
                window.location.replace(url.origin + "/index");
            };
        });
    }
});