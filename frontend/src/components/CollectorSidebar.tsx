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
            }
            >
                Upgrade
            </ActionButton>


        </div>
    )
}
