import Icon from "@/components/Icon.tsx";
import ActionButton from "@/components/ActionButton.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {error, collector} from "@/lib/types.ts";

export const getCollectorSidebar = (collector:collector, update : any, notification : any) => {
    return (
        <div>
            {collector.type == "metal" && (<div className="mt-2 mb-6"><Icon type="metal" size="54"/></div>)}
            {collector.type == "gems" && (<div className="mt-2 mb-6"><Icon type="gem" size="44"/></div>)}
            {collector.type == "gas" && (<div className="mt-2 mb-6"><Icon type="fuel" size="40"/></div>)}
            <h3 className="my-3">{collector.type.charAt(0).toUpperCase() + collector.type.slice(1) + " Collector"}</h3>
            <div className="my-5 flex flex-col justify-start"><span>Last collected</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toLocaleTimeString()}</span></div>
            <div className="my-5 flex flex-col justify-start"><span>Current level</span><span className="font-headline text-lg font-bold">{collector.level}</span></div>
            <div className="my-5 flex flex-col justify-start"><span>Stored Resource</span><span className="font-headline text-lg font-bold">{collector.amountStored}</span></div>
            <ActionButton onClick={() => ActionHandler.collectResources(collector.id)
                .then((data: any) => {
                    update();
                    data['error'] === undefined ? notification({
                        message: 'Successfully collected resources!',
                        type: 'info'
                    }) : notification({message: (data['error'] as error).message, type: 'warning'})
                })
            }
            >
                Collect
            </ActionButton>
            <ActionButton onClick={() => ActionHandler.upgradeCollector(collector.id)
                .then((data: any) => {
                    update();
                    data['error'] === undefined ? notification({
                        message: 'Successfully upgraded Collector!',
                        type: 'info'
                    }) : notification({message: (data['error'] as error).message, type: 'warning'})
                })
            }
            >
                Upgrade
                <div className={'flex justify-center items-center gap-2'}>
                    <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'metal'} size={'20'}/> {collector.upgradeCost.metal}</span>
                    <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'fuel'} size={'16'}/> {collector.upgradeCost.gas}</span>
                    <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'gem'} size={'20'}/> {collector.upgradeCost.gems}</span>
                </div>
            </ActionButton>


        </div>
    )
}
