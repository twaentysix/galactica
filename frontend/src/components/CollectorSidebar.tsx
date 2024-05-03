import Icon from "@/components/Icon.tsx";
import ActionButton from "@/components/ActionButton.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {error, collector} from "@/lib/types.ts";

export const getCollectorSidebar = (collector:collector, update : any, notification : any) => {
    return (
        <div>
            {collector.type == "metal" && (<div className="mt-2 mb-6"><Icon type="metal" size="54" /></div>)}
            {collector.type == "gems" && (<div className="mt-2 mb-6"><Icon type="gem" size="44" /></div>)}
            {collector.type == "gas" && (<div className="mt-2 mb-6"><Icon type="fuel" size="40" /></div>)}
            <h3 className="my-3">{collector.type.charAt(0).toUpperCase() + collector.type.slice(1) + " Collector"}</h3>
            <div className="my-5 flex flex-col justify-start"><span>Last collected</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toLocaleTimeString()}</span></div>
            <div className="my-5 flex flex-col justify-start"><span>Current level</span><span className="font-headline text-lg font-bold">{collector.level}</span></div>
            <ActionButton onClick={() => ActionHandler.collectResources(collector.id)
                .then((data:any) => {
                    update();
                    data['error'] === undefined ? notification({message:'Successfully collected resources!', type:'info'}) : notification({message:(data['error'] as error).message, type:'warning'})
                })
            }
            >
                Collect
            </ActionButton>
            <ActionButton onClick={() => ActionHandler.upgradeCollector(collector.id)
                .then((data:any) => {
                    update();
                    data['error'] === undefined ? notification({message:'Successfully upgraded Collector!', type:'info'}) : notification({message:(data['error'] as error).message, type:'warning'})
                })
            }
            >
                Upgrade
            </ActionButton>


        </div>
    )
}
