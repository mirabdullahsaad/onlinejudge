function select_option(that) {
    if (that.value == "0") {
        document.getElementById("input-0").style.display = "block";
        document.getElementById("input-1").style.display = "none";
        document.getElementById("input-2").style.display = "none";
        document.getElementById("input-3").style.display = "none";
    } else if (that.value == "1") {
        document.getElementById("input-0").style.display = "none";
        document.getElementById("input-1").style.display = "block";
        document.getElementById("input-2").style.display = "none";
        document.getElementById("input-3").style.display = "none";
    }else if (that.value == "2") {
        document.getElementById("input-0").style.display = "none";
        document.getElementById("input-1").style.display = "none";
        document.getElementById("input-2").style.display = "block";
        document.getElementById("input-3").style.display = "none";
    }else if (that.value == "3") {
        document.getElementById("input-0").style.display = "none";
        document.getElementById("input-1").style.display = "none";
        document.getElementById("input-2").style.display = "none";
        document.getElementById("input-3").style.display = "block";
    }
    else
    {
        document.getElementById("input-0").style.display = "none";
        document.getElementById("input-1").style.display = "none";
        document.getElementById("input-2").style.display = "none";
        document.getElementById("input-3").style.display = "none";
    }
}
function select_code_submit_option(that) {
    if (that.value == "code"){
        document.getElementById("code_editor").style.display = "block";
        document.getElementById("select_code_file").style.display = "none";
    }
    else if(that.value == "file")
    {
        document.getElementById("code_editor").style.display = "none";
        document.getElementById("select_code_file").style.display = "block";
    }
    else
    {
        document.getElementById("code_editor").style.display = "none";
        document.getElementById("select_code_file").style.display = "none";
    }
}

function ajax_f1(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           alert("Request sent");
        }
    };
    var name = document.getElementById("login-username").value;
    var pass = document.getElementById("login-password").value;
    var params = "u_name="+name+"&pass1="+pass;
    xhttp.open("POST", "login.php", true);
    xhttp.send(params);

}

function ajax_f2(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           alert("Request sent");
        }
    };
    var email = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var miubatch = document.getElementById("miubatch").value;
    var miuid = document.getElementById("miuid").value;
    var password = document.getElementById("password").value;
    var password2 = document.getElementById("password_confirmation").value;
    var params = "email="+email+"&u_name="+username+"&batch="+miubatch+"&miuid="+miuid+"&pass1="+password+"&pass2="+password2;
    xhttp.open("POST", "register.php", true);
    xhttp.send(params);
}