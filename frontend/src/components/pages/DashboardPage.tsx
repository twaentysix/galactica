import DataHandler from "@/lib/api/DataHandler";
import Icon from "../Icon";
import Layout from "../Layout";
import CustomCard from "../customCard";
import { useEffect, useState } from "react";
import {collector, base, fleet, galaxy, barracks} from "@/lib/types.ts";
import {renderCollector, renderFleet} from "@/lib/RenderFunctions.tsx";
import ActionSidebar from "../ActionSidebar";

const DashboardPage = () => {

    const [baseData, setBaseData] = useState<base[]>([])
    const [galaxiesData, setGalaxiesData] = useState<galaxy[]>([])
    const [selectedBase, setSelectedBase] = useState<base>()
    const [starMapActive, setStarMap] = useState<boolean>(false)

    const [actionBarType, setActionBarType] = useState<string>('')
    const [actionBarItem, setActionBarItem] = useState<collector | galaxy | barracks | fleet>()

    useEffect(() => {
        DataHandler.getBases().then(data => {setBaseData(data); data.length > 0 && setSelectedBase(data[0])});
        DataHandler.getGalaxies().then(data => {setGalaxiesData(data)});
    }, []);


    const changeBase = (base : base) => {
        starMapActive && setStarMap(false);
        setSelectedBase(base);
    };

     const changeSidebar = (_type:string, item: collector | galaxy | barracks | fleet) => {
        setActionBarItem(item);
        setActionBarType(_type);
    }

    const reload = () => {
        DataHandler.getBases().then(data => {setBaseData(data); data.length > 0 && setSelectedBase(data[0])});
        DataHandler.getGalaxies().then(data => {setGalaxiesData(data)});
    }


    return (
        <Layout>
            {/* First column using two grid sections */}
            <div className="col-span-3 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the first column */}
                <div className="bg-g_light h-10 px-4 flex items-center justify-center rounded-t-lg">
                    {/* Top bar content */}
                    <span className="text-g_dark font-headline font-bold">Control Unit</span>
                </div>
                {/* Content */}
                <div className="p-6">
                    <CustomCard
                        className={'mb-10 mt-5'}
                        key={galaxiesData}
                        backgroundColor="bg-g_planet_gradient"
                        title={'Star map'}
                        value={'Total galaxies: ' + galaxiesData.length}
                        onClick={() => setStarMap(true)}
                    />
                    <>
                        <h2 className="font-headline font-bold">Bases</h2>
                        <div className="flex items-center gap-1 mb-5">
                            <p>Total:</p>
                            <p className="font-bold">{baseData.length}</p>
                        </div>
                    </>
                    {baseData.map((base: base) => (
                        <CustomCard
                            className={'mb-5'}
                            key={base.id}
                            backgroundColor="bg-g_planet_gradient"
                            title={base["name"]}
                            status={"Created at: " + new Date(base["createdAt"]).toDateString()}
                            icon={<Icon type="medal" size="20"/>}
                            value={base["level"]}
                            svg={<Icon type="planet1" size="50"/>}
                            onClick={() => changeBase(base)}
                        />
                    ))}

                </div>
            </div>
            {/* Bigger column using 7 */}
            <div className="col-span-6 bg-g_base_gradient_0 rounded-lg">
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg justify-between">
                    {/* Left-aligned icons */}
                    <div className="flex items-center space-x-2 pl-4">
                        <div><Icon type="metal" size="25" /></div>
                        <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.metal}</p>
                        <div><Icon type="fuel" size="15" /></div>
                        <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.gas}</p>
                        <div><Icon type="gem" size="20" /></div>
                        <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.gems}</p>
                    </div>

                    {/* Right-aligned medals */}
                    <div className="flex items-center pr-4">
                        <div className="mr-2"><Icon type="medal" size="15" /></div>
                        <p className="text-md font-headline font-bold text-g_dark">{selectedBase?.level}</p>
                    </div>
                </div>
                {/* Content */}
                <div className="p-8">
                    {/* Add content here */}
                    {!starMapActive && <h2 className={'mb-5'}>Collectors</h2>}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {
                            starMapActive && galaxiesData.map((galaxy: galaxy) => (
                                <CustomCard
                                    className={'mb-5'}
                                    key={galaxy.id}
                                    backgroundColor="bg-g_planet_gradient"
                                    title={galaxy.name}
                                    status={"Amount of Planets: " + galaxy.planets.length}
                                    svg={<Icon type="planet2" size="50"/>}
                                    onClick={()=>{changeSidebar('galaxy',galaxy)}}
                                />
                            ))}
                        {
                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.collectors as collector[]).map((collector: collector) => (
                                renderCollector(collector, ()=>{changeSidebar('collector',collector)})
                            ))
                        }
                    </div>
                    {!starMapActive&& <h2 className={'mb-5'}>Harbour</h2>}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {

                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.harbour.fleets as fleet[]).map((fleet: fleet) => (
                                renderFleet(fleet, ()=>{changeSidebar('fleet',fleet)})
                            ))
                        }
                    </div>
                </div>
            </div>
            {/* Third column using 3 */}
            <div className="col-span-3 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the third column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg justify-center">
                        <span className="text-g_dark font-headline font-bold">Action Unit</span>
                </div>
                {/* Content */}
                <div className="p-4">
                    {/* Add content here */}
                    <ActionSidebar
                        type={actionBarType}
                        item={actionBarItem}
                        reload={() => reload()}
                    />
                </div>
            </div>
        </Layout>
    );
}

export default DashboardPage;
