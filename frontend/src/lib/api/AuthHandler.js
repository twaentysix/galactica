import axios from "axios";
import ApiHandler from "@/lib/api/ApiHandler.js";

class AuthHandler{

    static async login (name, password) {
        return axios({
            method: 'post',
            url: ApiHandler.BASE_URL + "auth/login",
            headers: ApiHandler.getHeaders('auth'),
            data: {
                name: name,
                password: password
            }
        }).then(function (response) {
            sessionStorage.setItem('jwt', response.data['jwt'])
            return response.data;
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async register (name, email, password) {
        return axios({
            method: 'post',
            url: ApiHandler.BASE_URL + "/auth/register",
            headers: ApiHandler.getHeaders('auth'),
            data: {
                name: name,
                password: password,
                email: email,
            }
        }).then(function (response) {
            return response.data;
        }).catch(function (error){
            return error.response.data;
        });
    }
}

export default AuthHandler;