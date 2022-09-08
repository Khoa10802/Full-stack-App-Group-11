window.addEventListener('load', function(){
    let id = localStorage.getItem("id") ?? null;
    const data = {
        id: id,
    };
    const response = fetch('/common/loginCheck.php', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(data),
    }).then((response) => response.json()).then((data) => {
        if(data.response === "false") {
            this.window.location.href="/index.html";
        }
    });
});

const id = localStorage.getItem("id");
const uName = localStorage.getItem("name");
const img = localStorage.getItem("img");
const adr = localStorage.getItem("adr");
const gubn = localStorage.getItem("gubn"); 
let gbnName;

if(gubn === "1"){
    gbnName = "Customers";
} else if(gubn === "2"){
    gbnName = "Vendors";
} else {
    gbnName = "Shippers";
}

document.open();
document.write(`<h1>hi ${gbnName} <span style="color: green;">${uName}</span></h1>`);
document.write(`<p>ID: ${id}</p>`);

if(gubn === "3") {
    document.write(`<p>hub: ${adr}</p>`);
} else {
    document.write(`<p>NAME: ${uName}</p>`);
    document.write(`<p>address: ${adr}</p>`);
}
document.write(`<p class=change> profile: <img src=/member/img/${img} width="199" height="200"><input type=file id=profile value=change onchange=imgUpload() /></p>`);
document.write(`<p>class: ${gbnName}</p>`);
document.close();

function logout(){
    localStorage.clear();
    window.location.href="/index.html";
}

async function imgUpload(){
    const fileInput = document.querySelector("#profile");
    let formData = new FormData();
    formData.append("file", fileInput.files[0]);

    const response = await fetch('/join/img.php', {
        method: 'POST',
        body: formData
    }).then((response) => response.json()).then((data) => {
        console.log(data);
        let changeProfile = document.querySelector(".change");
        changeProfile.src = `/member/img/${fileInput.files[0].name}`;
        localStorage.setItem("img", fileInput.files[0].name);
        location.reload();
    });
}
