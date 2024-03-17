document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var hashedPassword = hashPassword(password);

    saveLoginData(username, hashedPassword);
});

function hashPassword(password) {
    return password.split('').reverse().join('');
}

function saveLoginData(username, hashedPassword) {
    var loginData = {
        "username": username,
        "password": hashedPassword
    };

    var jsonData = JSON.stringify(loginData);

    var fs = require('fs');
    fs.writeFileSync('PlayerData.json', jsonData);
}
