const form = document.querySelector(".signup form"),
nextBtn = form.querySelector(".btn-sides button");

form.onsubmit = (e)=>{
    e.preventDeafult();   
}
nextBtn.onclick = ()=>{
    //ajax
    let xhr = new XMLHttpRequest(); // create xml obj.
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
            }
        }
    }
    //form data through ajax to php
    let formData = new FormData(form); //creating new formData object
    xhr.send(formData); //sending the form data to php
}