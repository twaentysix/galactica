document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const data = {
        name: username,
        password: password
    }
    const http = new XMLHttpRequest()
    http.open('POST', 'http://localhost:8080/api/auth/login')
    http.setRequestHeader('accept', 'application/json');
    let jwt = null;
    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState === 4 && http.status === 200) {
            jwt = http.responseText;
            jwt = JSON.parse(jwt);

            if(jwt['jwt']){
                jwt = jwt['jwt'];
                saveLoginData(jwt);
            }
        }
    }
    http.setRequestHeader('Content-type', 'application/json')
    http.send(JSON.stringify(data))
});

function hashPassword(password) {
    return password.split('').reverse().join('');
}

function saveLoginData(token) {
    sessionStorage.setItem('jwt', token)
}
