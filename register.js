document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();


    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const email = document.getElementById("email").value;
    const data = {
        name: username,
        password: password,
        email: email,
    }
    const http = new XMLHttpRequest()
    http.open('POST', 'http://localhost:8080/api/auth/register')
    http.setRequestHeader('accept', 'application/json');
    let jwt = null;
    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState === 4 && http.status === 200) {
            jwt = http.responseText;
            window.location='loginPage.html'
        }
        if(http.readyState === 4 && http.status === 400) {
            let error = http.responseText;
            error = JSON.parse(error);
            alert(error['error']['message']);
        }
    }

    http.setRequestHeader('Content-type', 'application/json')
    http.send(JSON.stringify(data))
});

function saveLoginData(token) {
    sessionStorage.setItem('jwt', token)
}
