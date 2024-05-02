import {collector, fleet, galaxy, planet} from "@/lib/types";
import CustomCard from "@/components/customCard.tsx";
import Icon from "@/components/Icon.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";

const ActionSidebar = ({type : _type, item : item } : {type : string, item: any}) => {
   switch(_type){
       case 'collector':
           return getCollectorSidebar(item as collector)
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

const getCollectorSidebar = (collector:collector) => {
    return (
        <div>
            <h1>{collector.type}</h1>
            <p>{new Date(collector.lastCollected).toDateString()}</p>
            <p>{collector.id}</p>
            <Button onClick={() => ActionHandler.collectResources(collector.id)}>
                <h2>Collect</h2>
            </Button>
            <Button>
                <h2>Upgrade</h2>
            </Button>
        </div>
    )
}

const getFleetSidebar = (fleet:fleet) => {
    return (
        <div>{fleet.name}</div>
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