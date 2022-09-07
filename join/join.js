const submit = document.querySelector("#submit");

function inputChange(e){
    const uName = document.querySelector(".name");
    const adr = document.querySelector(".address");
    if(e.value === "1"){
        uName.innerHTML = "Name";
        adr.innerHTML = "address";
    } else if(e.value === "2"){
        uName.innerHTML = "Business Name";
        adr.innerHTML = "Business address";
    } else {
        
    }
}

submit.addEventListener("click", doJoin);

function doJoin(e) {
    e.preventDefault();
    const userId = document.querySelector("#userId").value;
    const pwd = document.querySelector("#pw").value;
    const profile = document.querySelector("#profile").value;
    const name = document.querySelector("#userName").value;
    const address = document.querySelector("#address").value;
    const gubn = document.querySelector('input[name="gubn"]:checked').value;
    let flag = validCheck(userId, pwd, profile, name, address);
    if (flag) {
        imgUpload();
        const makeJson = {
            id: userId,
            pw: pwd,
            pf: profile,
            name: name,
            adr: address,
            gubn: gubn,
        };
        postData('join.php', makeJson).then((data) => {
            console.log(data);
        });
    }
}

async function imgUpload(){
    let file = document.querySelector("#profile").files;
    let formData = new FormData();
    formData.append("file", file[0]);

    const response = await fetch('./img.php', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData
    }).then((response) => response.json()).then((data) => {
        console.log(data);
    });
}

function validCheck(userId, pwd, profile, name, address){
    if(!validDetailCheck(userId, "Please enter your ID")) return false;
    if(!validDetailCheck(pwd, "Please enter your password")) return false;
    if(!validDetailCheck(profile, "Please enter your profileImage")) return false;
    if(!validDetailCheck(name, "Please enter your name")) return false;
    if(!validDetailCheck(address, "Please enter your address")) return false;

    if(!validIdCheck(userId, "Please enter your ID in English and numbers 8 to 15")) return false;
    if(!validPassCheck(pwd, "Please enter your password in UpLow and numbers and special 8 to 20")) return false;

    return true;
}

function validDetailCheck(key, msg){
    if(key == ""){
        alert(msg);
        return false;
    }

    return true;
}

function validIdCheck(key, msg){
    let idRegExp = /^[a-zA-z0-9]{8,15}$/;
    if (!idRegExp.test(key)){
        alert(msg);
        document.querySelector("#userId").value="";
        return false;
    }
    return true;
}

function validPassCheck(key, msg){
    let passUpLow = /(?=.*?[a-z])(?=.*?[A-Z])/;
    let passSpecial = /(?=.*?[0-9])(?=.*?[#?!@$%^&*-])/;
    let passSize = /^.{8,16}$/;

    if (passUpLow.test(key)){
        if(passSpecial.test(key)){
            if(passSize.test(key)){
                return true;
            }
        }
    }
    alert(msg);
    document.querySelector("#pw").value="";
    return false;
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
    });
    window.location.href="../index.html";
    return response.json();
}
