import axios from "axios";


class ApiHandler{

    static BASE_URL = "http://localhost:8080/api/"
    static JWT = '';

    static setJwt () {
        if(this.isLoggedIn()){
            this.JWT = sessionStorage.getItem('jwt');
            return true
        }
        return false
    }

    static isLoggedIn () {
        const jwt = sessionStorage.getItem('jwt');
        return jwt !== null;

    }

    static getHeaders (type) {
        if(type === 'data'){
            return {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'Authorization': 'Bearer ' + ApiHandler.JWT,
            };
        }
        if(type === 'auth'){
            return {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                Accept: 'application/json',
            }
        }
    }

    static async sendRequest (method, url, headers) {
        return await axios({
                            method: method,
                            url: url,
                            headers: headers,
                        }).then(function (response) {
                            return response.data['data'];
                        }).catch(function (error){
                            return error.response.data;
                        });
    }
}

export default ApiHandler;