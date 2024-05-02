import {collector, fleet, galaxy, planet} from "@/lib/types";
import CustomCard from "@/components/customCard.tsx";
import Icon from "@/components/Icon.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";

const ActionSidebar = ({type : _type, item : item, reload : reload } : {type : string, item: any, reload : any}) => {
   switch(_type){
       case 'collector':
           return getCollectorSidebar(item as collector, reload)
       case 'galaxy':
           return getGalaxySidebar(item as galaxy)
       case 'fleet':
           return getFleetSidebar(item as fleet)
       case 'barracks':
           return getBarracksSidebar()
       default:
           return <div></div>

   }
}

export default ActionSidebar;

const getCollectorSidebar = (collector:collector, update : any) => {
    return (
        <div>
            <h1>{collector.type}</h1>
            <p>{new Date(collector.lastCollected).toDateString()}</p>
            <p>{collector.id}</p>
            <Button onClick={() => ActionHandler.collectResources(collector.id).then(update)}>
                <h2>Collect</h2>
            </Button>
            <Button onClick={() => ActionHandler.upgradeCollector(collector.id).then(update)}>
                <h2>Upgrade</h2>
            </Button>
        </div>
    )
}

const getFleetSidebar = (fleet:fleet) => {
    return (
        <div>
            <h1>{fleet.name}</h1>
            {/* add onclick new dialog for updating fleet*/}
            <Button ><h2>Update Ships</h2></Button>
            {/* add onclick new dialog for starting expeditions */}
            <Button ><h2>Start expedition</h2></Button>
        </div>

    )
}

const getGalaxySidebar = (galaxy:galaxy) => {
    return (
        <div>
            {
                galaxy.planets.map((planet:planet) => (
                        <CustomCard
                            className={'mb-5'}
                            key={planet.id}
                            backgroundColor="bg-g_planet_gradient"
                            title={planet.name}
                            status={ planet.occupied ? "Occupied by " + planet.occupiedBy.username : ''}
                            svg={<Icon type="planet2" size="50"/>}
                        />
                ))
            }
            {/* add onclick new dialog for creating a base */}
            <Button>
                <h2>New Base</h2>
            </Button>
        </div>
    )
}

const getBarracksSidebar = () => {
    return (
        <div>Barracks</div>
    )
}