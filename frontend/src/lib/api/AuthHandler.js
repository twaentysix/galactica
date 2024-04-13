import axios from "axios";

class AuthHandler{

    static login (name, password) {
        axios({
            method: 'post',
            url: 'http://localhost:8080/api/auth/login',
            headers:{
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            data: {
                name: name,
                password: password
            }
        }).then(function (response) {
            if(response.data !== null){
                sessionStorage.setItem('jwt', response.data['jwt'])
                return true;
            }
            else{
                return response['error']['message'];
            }
        });
    }

    static register (name, email, password) {
        axios({
            method: 'post',
            url: 'http://localhost:8080/api/auth/register',
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            data: {
                name: name,
                password: password,
                email: email,
            }
        }).then(function (response) {
            if (response.data.data !== null) {
                return true;
            } else {
                return response['error']['message'];
            }
        });
    }
}

export default AuthHandler;