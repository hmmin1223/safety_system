document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();

    const user = document.getElementById("username").value;
    const pass = document.getElementById("password").value;
    const error = document.getElementById("error");

    // if(user === "" || pass === ""){
    //     error.textContent = "入力してください";
    //     return;
    // }

    // 仮ログイン（後でPHPに変更）
    if(user === "admin" && pass === "1"){
        window.location.href = "../states.html";
    } else {
        error.textContent = "ログイン失敗";
    }
});