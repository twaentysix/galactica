import axios from "axios";
import ApiHandler from "@/lib/api/ApiHandler.js";

class DataHandler {

    static async getGalaxies () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "galaxies",
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
                return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getGalaxy (galaxyId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "galaxies/"+galaxyId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getPlanets () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "planets",
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getPlanet (planetId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "planets/"+planetId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getBases () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "bases",
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getResources (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "resources"+baseId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getHarbour (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "harbour"+baseId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getFleets (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "fleets/"+baseId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getShipTypes () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "ship-types",
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }

    static async getCollectors (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        return await axios({
            method: 'get',
            url: ApiHandler.BASE_URL + "collectors/"+baseId,
            headers: ApiHandler.getHeaders('data'),
        }).then(function (response) {
            return response.data['data'];
        }).catch(function (error){
            return error.response.data;
        });
    }
}

export default DataHandler;