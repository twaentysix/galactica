import ApiHandler from "@/lib/api/ApiHandler.js";

class ActionHandler{

    static async createBase (galaxy_id, name) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "bases/create";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'galaxy_id': galaxy_id, 'name': name}
        return await ApiHandler.sendActionRequest('post', url, headers, payload);
    }

    static async upgradeBase (base_id) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "bases/upgrade";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'base_id':base_id}
        return await ApiHandler.sendActionRequest('patch', url, headers, payload);
    }

    static async createFleet (harbour_id, name) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "fleets/create";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'harbour_id': harbour_id, 'name': name}
        return await ApiHandler.sendActionRequest('post', url, headers, payload);
    }

    static async updateFleet (fleet_id, light_fighter, heavy_fighter, cruiser, transporter, battleships) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "fleets/update";
        const headers = ApiHandler.getHeaders('action');
        const payload = {
                'fleet_id': fleet_id,
                'light_fighter': light_fighter,
                'heavy_fighter': heavy_fighter,
                'cruiser': cruiser,
                'transporter': transporter,
                'battleships': battleships,

        }
        return await ApiHandler.sendActionRequest('patch', url, headers, payload);
    }

    static async registerExpedition (fleet_id, duration) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "expeditions/register";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'fleet_id': fleet_id, 'duration': duration}
        return await ApiHandler.sendActionRequest('post', url, headers, payload);
    }

    static async upgradeCollector (collector_id) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "collectors/upgrade";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'collector_id': collector_id}
        return await ApiHandler.sendActionRequest('patch', url, headers, payload);
    }

    static async collectResources (collector_id) {
        if(!ApiHandler.setJwt()){
            return {'error': {'message': "User not logged in!"}};
        }
        const url = ApiHandler.BASE_URL + "collectors/collect";
        const headers = ApiHandler.getHeaders('action');
        const payload = {'collector_id': collector_id}
        return await ApiHandler.sendActionRequest('patch', url, headers, payload);
    }
}

export default ActionHandler;