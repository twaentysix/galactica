import axios from "axios";


class ApiHandler{

    static getJwt () {
        const jwt = sessionStorage.getItem('jwt');
        return jwt;
    }

    static isLoggedIn () {
        const jwt = sessionStorage.getItem('jwt');
        if(jwt===null){
            return false;
        }
        return true;
    }
}

export default ApiHandler;