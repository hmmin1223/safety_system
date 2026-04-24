document.getElementById("statusForm").addEventListener("submit", function(e){
    e.preventDefault();

    const status = document.getElementById("status").value;
    const msg = document.getElementById("msg");

    if(status === ""){
        msg.style.color = "red";
        msg.textContent = "安否状態を選択してください";
        return;
    }

    // 仮登録
    msg.style.color = "green";
    msg.textContent = "登録しました（仮）";
});

function logout(){
    window.location.href = "login.html";
}