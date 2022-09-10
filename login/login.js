const submit = document.querySelector("#submit");

submit.addEventListener("click", doLogin);

function doLogin(){
    const userId = document.querySelector("#userId").value;
    const pwd = document.querySelector("#pw").value;
    const gubn = document.querySelector('input[name="gubn"]:checked').value;
    const makeJson = {
        id: userId,
        pw: pwd,
        gubn: gubn,
    };
    postData('/login/login.php', makeJson).then((data) => {
        console.log(data);
        if(data.response === "true") {
            localStorage.setItem("id", data.id);
            localStorage.setItem("name", data.name);
            localStorage.setItem("adr", data.adr);
            localStorage.setItem("img", data.img);
            localStorage.setItem("gubn", data.gbn);
            window.location.href=`/member.php`;
        } else {
            alert("Check account information");
        }
    });
}

async function postData(url, data){
    console.log(url);
    console.log(data);
    const response = await fetch(url, {
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
    }).then((response) => response.json())
    return response;
}
