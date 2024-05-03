import {collector, fleet, galaxy} from "@/lib/types";
import {getFleetSidebar} from "@/components/FleetSidebar.tsx";
import {getCollectorSidebar} from "@/components/CollectorSidebar.tsx";
import {getGalaxySidebar} from "@/components/GalaxySidebar.tsx";
import {getBarracksSidebar} from "@/components/BarracksSideBar.tsx";

const ActionSidebar = ({type : _type, item : item, reload : reload, notification : notification } : {type : string, item?: any, reload : any, notification : any}) => {

    switch(_type){
        case 'collector':
            return getCollectorSidebar(item as collector, reload, notification)
        case 'galaxy':
            return getGalaxySidebar(item as galaxy, reload, notification)
        case 'fleet':
            return getFleetSidebar(item as fleet, reload, notification)
        case 'barracks':
            return getBarracksSidebar()
        default:
            return <div></div>

    }
}

export default ActionSidebar;