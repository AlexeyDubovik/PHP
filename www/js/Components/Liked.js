function LikingHandler(Liking, id){
    let like    = Liking.querySelector(".like");
    let dislike = Liking.querySelector(".dislike");
    dislike.onclick = sendToServer(0, id);
    like.onclick    = sendToServer(1, id);
}
function sendToServer(reaction, id){
    return (e) => {
        //console.log(id);
        let span = e.target.parentNode.querySelector('span');
        let formData = new FormData();
        formData.append('reaction', reaction);
        formData.append('review_id', id);
        fetch( window.location.href, {
            method:"POST",
            body: formData
        })
        .then(r => r.json())
        .then(j =>{
            console.log(j.status);
            if(j.status === "success"){
                let num = Number(span.innerText);
                span.innerText = num + 1;
            }
        })
    }
}
export {LikingHandler}