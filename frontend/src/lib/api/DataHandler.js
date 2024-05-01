import ApiHandler from "@/lib/api/ApiHandler.js";

class DataHandler {

    static async getGalaxies () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "galaxies";
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getGalaxy (galaxyId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "galaxies/"+galaxyId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getPlanets () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "planets";
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getPlanet (planetId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "planets/"+planetId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getBases () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "bases";
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getResources (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "resources/"+baseId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getHarbour (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "harbour/"+baseId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getFleets (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "fleets/"+baseId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getShipTypes () {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "ship-types";
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }

    static async getCollectors (baseId) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "collectors/"+baseId;
        const headers = ApiHandler.getHeaders('data');
        return await ApiHandler.sendDataRequest(url, headers);
    }
}

export default DataHandler;