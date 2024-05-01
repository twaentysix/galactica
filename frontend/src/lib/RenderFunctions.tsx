import Icon from "@/components/Icon.tsx";
import {collector, fleet} from "@/lib/types.ts";
import CustomCard from "@/components/customCard.tsx";

export function renderCollector(collector : collector) {
    switch (collector.type) {
    case 'metal':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_grey_gradient"
            title={'Metal Collector'}
            status={"Last collected at: " + new Date(collector.lastCollected).toDateString()}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="metal" size="50"/>}
        />
    case 'gas':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_red_gradient"
            title={'Fuel Collector'}
            status={"Last collected at: " + new Date(collector.lastCollected).toDateString()}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="fuel" size="30"/>}
        />
    case 'gems':
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_green_gradient"
            title={'Gem Collector'}
            status={"Last collected at: " + new Date(collector.lastCollected).toDateString()}
            icon={<Icon type="medal" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="gem" size="40"/>}
        />
    default:
        return <CustomCard
            key={collector.id}
            backgroundColor="bg-g_planet_gradient"
            title={collector["type"]}
            status={"Las Updated at: " + new Date(collector.lastCollected).toDateString()}
            icon={<Icon type="gas" size="20"/>}
            value={collector["level"]}
            svg={<Icon type="planet1" size="50"/>}
        />
}
}

export function renderFleet(fleet : fleet) {
    return <CustomCard
                key={fleet.id}
                backgroundColor="bg-g_grey_gradient"
                title={fleet.name}
                status={"Ships " + (fleet.lightFighter + fleet.heavyFighter + fleet.battleship + fleet.transporter + fleet.cruiser)}
            />
}
