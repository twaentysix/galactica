import {collector, error, fleet, galaxy, planet} from "@/lib/types";
import CustomCard from "@/components/customCard.tsx";
import Icon from "@/components/Icon.tsx";
import ActionButton from "./ActionButton";
import ActionHandler from "@/lib/api/ActionHandler";

const ActionSidebar = ({type : _type, item : item, reload : reload, notification : notification } : {type : string, item?: any, reload : any, notification : any}) => {
   switch(_type){
       case 'collector':
           return getCollectorSidebar(item as collector, reload, notification)
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

const getCollectorSidebar = (collector:collector, update : any, notification : any) => {
    return (
        <div>
            {collector.type == "metal" && (<div className="mt-2 mb-6"><Icon type="metal" size="54" /></div>)}
            {collector.type == "gems" && (<div className="mt-2 mb-6"><Icon type="gem" size="44" /></div>)}
            {collector.type == "gas" && (<div className="mt-2 mb-6"><Icon type="fuel" size="40" /></div>)}
            <h3 className="my-3">{collector.type.charAt(0).toUpperCase() + collector.type.slice(1) + " Collector"}</h3>
            <div className="flex gap-1 mb-2"><span className="">Last collected: </span><p className="font-bold">{new Date(collector.lastCollected).toLocaleTimeString()}</p></div>
            <div className="flex gap-1 mb-10"><span className="">Current level: </span><p className="font-bold">{collector.level}</p></div>
            <ActionButton onClick={() => ActionHandler.collectResources(collector.id)
                .then((data:any) => {
                    update();
                    data['error'] === undefined ? notification({message:'Successfully collected resources!', type:'info'}) : notification({message:(data['error'] as error).message, type:'warning'})
                })
            }
            >
            <h3 className="my-3">{}</h3>
            <p>{new Date(collector.lastCollected).toDateString()}</p>
            <p>{collector.id}</p>

                Collect
            </ActionButton>
            <ActionButton onClick={() => ActionHandler.upgradeCollector(collector.id)
                                            .then((data:any) => {
                                                update();
                                                data['error'] === undefined ? notification({message:'Successfully upgraded Collector!', type:'info'}) : notification({message:(data['error'] as error).message, type:'warning'})
                                            })
                                    }>
                Upgrade
            </ActionButton>
        </div>
    )
}

const getFleetSidebar = (fleet:fleet) => {
    return (
        <div>
            <h1>{fleet.name}</h1>
            {/* add onclick new dialog for updating fleet*/}
            <ActionButton>Update ships</ActionButton>
            {/* add onclick new dialog for starting expeditions */}
            <ActionButton>Start expedition</ActionButton>
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
            <ActionButton>
                New Base    
            </ActionButton>
        </div>
    )
}

const getBarracksSidebar = () => {
    return (
        <div>Barracks</div>
    )
}