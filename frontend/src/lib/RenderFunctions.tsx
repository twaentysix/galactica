

import Icon from "@/components/Icon.tsx";
import {collector, fleet} from "@/lib/types.ts";
import CustomCard from "@/components/customCard.tsx";

export function renderCollector(collector : collector, changeSidebar:any) {
    switch (collector.type) {
    case 'metal':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_grey_gradient"
            title={'Metal Collector'}
            status={<div className="my-3 flex flex-col justify-start"><span>Last collected:</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toDateString()}</span></div>}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="metal" size="50"/>}
            onClick={changeSidebar}
        />
    case 'gas':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_red_gradient"
            title={'Fuel Collector'}
            status={<div className="my-3 flex flex-col justify-start"><span>Last collected:</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toDateString()}</span></div>}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="fuel" size="30"/>}
            onClick={changeSidebar}
        />
    case 'gems':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_green_gradient"
            title={'Gem Collector'}
            status={<div className="my-3 flex flex-col justify-start"><span>Last collected:</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toDateString()}</span></div>}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="gem" size="40"/>}
            onClick={changeSidebar}
        />
    default:
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_planet_gradient"
            title={collector["type"]}
            status={<div className="my-3 flex flex-col justify-start"><span>Last time updated:</span><span className="font-headline text-lg font-bold">{new Date(collector.lastCollected).toDateString()}</span></div>}
            icon={<Icon type="gas" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="planet1" size="50"/>}
        />
}
}

export function renderFleet(fleet : fleet, changeSidebar:any) {
    return <CustomCard
                key={fleet.id}
                backgroundColor="bg-g_base_gradient_1"
                title={fleet.name}
                status={<div className="my-3 flex flex-col justify-start"><span>Ships:</span><span className="font-headline text-lg font-bold">{fleet.lightFighter + fleet.heavyFighter + fleet.battleship + fleet.transporter + fleet.cruiser}</span></div>}
                onClick={changeSidebar}
            />
}
