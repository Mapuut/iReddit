
function login() {
    name = document.getElementById('id-modal-login-usernamefield').value;

    httpGetAsync("login.php", {
        "name":name,
        "password":document.getElementById('id-modal-login-passwordfield').value
    }, function(response) {
        if (response == "Login successful!") {
            document.getElementById("id-header-register-area").innerHTML = "<table class=\"button-custom-blue noselect\" onclick=\"openPostModal()\"><tr><th><div class=\"button-custom-text\">Add Post</div></th></tr></table>";
            document.getElementById("id-header-login-area").innerHTML = "<table class=\"button-custom-red noselect\" onclick=\"logOut()\"><tr><th><div class=\"button-custom-text\">Log out</div></th></tr></table>";
            document.getElementById('id-modal-login-usernamefield').value = "";
            document.getElementById('id-modal-login-passwordfield').value = "";
            pushMessageSucess("Welcome back, " + name);
            closeModals();
        } else {
            pushMessageError(response);
        }
        
    });
}

function logOut() {
    httpGetAsync("logout.php", null, function(response) {
        document.getElementById("id-header-register-area").innerHTML = "<table class=\"button-custom-blue noselect\" onclick=\"openRegisterModal()\"><tr><th><div class=\"button-custom-text\">Register</div></th></tr></table>";
        document.getElementById("id-header-login-area").innerHTML = "<table class=\"button-custom-green noselect\" onclick=\"openLoginModal()\"><tr><th><div class=\"button-custom-text\">Login</div></th></tr></table>";
        pushMessageSucess(response);
    });
}

function register() {
    name = document.getElementById('id-modal-register-usernamefield').value;
    password = document.getElementById('id-modal-register-usernamefield').value;

    httpGetAsync("register.php", {
        "name":name,
        "password":password,
        "fullname":document.getElementById('id-modal-register-fullnamefield').value,
        "email":document.getElementById('id-modal-register-emailfield').value
    }, function(response) {
        if (response == "Registration successful!") {
            document.getElementById('id-modal-login-usernamefield').value = name;
            document.getElementById('id-modal-login-passwordfield').value = password;
            closeModals();
            openLoginModal();
            pushMessageSucess(response);
        } else {
            pushMessageError(response);
        }
        
    });
}

function post() {
    title = document.getElementById('id-modal-post-titlefield').value;
    text = document.getElementById('id-modal-post-textfield').value;

    httpGetAsync("addpost.php", {
        "title":title,
        "text":text
    }, function(response) {
        if (response == "Post added!") {
            document.getElementById('id-modal-post-titlefield').value = "";
            document.getElementById('id-modal-post-textfield').value = "";
            closeModals();
            pushMessageSucess(response);
            loadContent(curtag);
        } else {
            pushMessageError(response);
        }
        
    });
}

function openPost(id) {
    httpGetAsync("loadpost.php", {"id":id}, function(response) {
        if (response == "") {
            pushMessageError("Something went wrong");
        } else {
            var element = document.getElementById("id-main");
            var newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
            document.getElementById("id-main-posts").innerHTML = response;
            document.getElementById("id-main-header-title").innerHTML = "Post-id: " + id + " |";
        }
        
    });
}

function vote(vote, id) {
    httpGetAsync("vote.php", {"vote":vote, "id":id}, function(response) {
        if (response == "Voted!") {
            pushMessageSucess(response);
            httpGetAsync("loadnews.php", {"tag":curtag}, function(response) {
                if (response == "") {
                    pushMessageError("Something went wrong");
                } else {
                    document.getElementById("id-main-posts").innerHTML = response;
                }
                
            });
        } else {
            pushMessageError(response);
        }
        
    });
}

var curtag = "Hot";
function loadContent(tag) {
    httpGetAsync("loadnews.php", {"tag":tag}, function(response) {
        if (response == "") {
            pushMessageError("Something went wrong");
        } else {
            curtag = tag;
            var element = document.getElementById("id-main");
            var newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
            document.getElementById("id-main-posts").innerHTML = response;
            document.getElementById("id-main-header-title").innerHTML = tag + " |";
        }
        
    });
}

var errorTimeout;
function pushMessageError(message) {
    clearTimeout(errorTimeout);
    document.getElementById("id-modal-message-error-text").innerHTML = message;
    document.getElementById("id-modal-message-error").style.display = "block";
    errorTimeout = setTimeout(function() { document.getElementById("id-modal-message-error").style.display = "none"; }, 4500);
}

var successTimeout;
function pushMessageSucess(message) {
    clearTimeout(successTimeout);
    document.getElementById("id-modal-message-success-text").innerHTML = message;
    document.getElementById("id-modal-message-success").style.display = "block";
    successTimeout = setTimeout(function() { document.getElementById("id-modal-message-success").style.display = "none"; }, 2500);
}

function openLoginModal() {
    document.getElementById('id-modal-login').style.display = "block";
    setTimeout(function() { document.getElementById('id-modal-login-usernamefield').focus(); }, 500);
}

function openRegisterModal() {
    document.getElementById('id-modal-register').style.display = "block";
    setTimeout(function() { document.getElementById('id-modal-register-fullnamefield').focus(); }, 500);
}

function openPostModal() {
    document.getElementById('id-modal-post').style.display = "block";
    setTimeout(function() { document.getElementById('id-modal-post-titlefield').focus(); }, 500);
}

function closeModals() {
    document.getElementById('id-modal-login').style.display = "none";
    document.getElementById('id-modal-register').style.display = "none";
    document.getElementById('id-modal-post').style.display = "none";
}

function prepareModals() {
	var loginModal = document.getElementById('id-modal-login');
    var registerModal = document.getElementById('id-modal-register');
    var postModal = document.getElementById('id-modal-post');

	window.onclick = function(event) {
	    if ((event.target == loginModal) || (event.target == registerModal) || (event.target == postModal) ) {
	        closeModals();
	    }
	}
}

function setEnterKeyFunctionality() {

    document.getElementById('id-modal-login-usernamefield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          document.getElementById('id-modal-login-passwordfield').focus();
          return false;
        }
    }

    document.getElementById('id-modal-login-passwordfield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          login();
          return false;
        }
    }


    document.getElementById('id-modal-register-fullnamefield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          document.getElementById('id-modal-register-emailfield').focus();
          return false;
        }
    }

    document.getElementById('id-modal-register-emailfield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          document.getElementById('id-modal-register-usernamefield').focus();
          return false;
        }
    }

    document.getElementById('id-modal-register-usernamefield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          document.getElementById('id-modal-register-passwordfield').focus();
          return false;
        }
    }


    document.getElementById('id-modal-register-passwordfield').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
          register();
          return false;
        }
    }

}




function httpGetAsync(url, data, callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) callback(xmlHttp.responseText);
    }

    if (data != null) {
        xmlHttp.open("POST", url, true); // true for asynchronous
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send(serialize(data));
    } else {
        xmlHttp.open("GET", url, true); // true for asynchronous 
        xmlHttp.send(null);
    }
}

function serialize(obj) {
    var str = [];
    for(var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}