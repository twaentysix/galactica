import DataHandler from "@/lib/api/DataHandler";
import Icon from "../Icon";
import Layout from "../Layout";
import CustomCard from "../customCard";
import { useEffect, useState } from "react";
import {collector, base, fleet, galaxy} from "@/lib/types.ts";
import {renderCollector, renderFleet} from "@/lib/RenderFunctions.tsx";

const DashboardPage = () => {

    const [baseData, setBaseData] = useState<base[]>([])
    const [galaxiesData, setGalaxiesData] = useState<galaxy[]>([])
    const [selectedBase, setSelectedBase] = useState<base>()
    const [starMapActive, setStarMap] = useState<boolean>(false)

    useEffect(() => {
        DataHandler.getBases().then(data => {setBaseData(data); data.length > 0 && setSelectedBase(data[0])});
        DataHandler.getGalaxies().then(data => {setGalaxiesData(data)});
    }, []);


    const changeBase = (base : base) => {
        starMapActive && setStarMap(false);
        setSelectedBase(base);
    };

    return (
        <Layout>
            {/* First column using two grid sections */}
            <div className="col-span-2 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the first column */}
                <div className="bg-g_light h-10 px-4 flex items-center justify-center rounded-t-lg">
                    {/* Top bar content */}
                    <span className="text-g_dark font-headline font-bold">Control Unit</span>
                </div>
                {/* Content */}
                <div className="">
                    <CustomCard
                        className={'mb-10 mt-5'}
                        key={galaxiesData}
                        backgroundColor="bg-g_planet_gradient"
                        title={'Sternenkarte'}
                        value={'Total Galaxies: ' + galaxiesData.length}
                        svg={<Icon type="planet1" size="50"/>}
                        onClick={() => setStarMap(true)}
                    />
                    <div className="m-4">
                        <p className="text-md font-main font-bold">Bases</p>
                        <div className="flex items-center">
                            <p className="text-sm text-muted mr-2">Total:</p>
                            <p className="text-md font-main font-bold">{baseData.length}</p>
                        </div>
                    </div>
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
            <div className="col-span-7 bg-g_base_gradient_0 rounded-lg">
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
                        <p className="text-md">{selectedBase?.level}</p>
                    </div>
                </div>
                {/* Content */}
                <div className="p-8">
                    {/* Add content here */}
                    {!starMapActive && <h1 className={'mb-5'}>Collectors</h1>}
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
                                />
                            ))}
                        {
                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.collectors as collector[]).map((collector: collector) => (
                                renderCollector(collector)
                            ))
                        }
                    </div>
                    {!starMapActive&& <h1 className={'mb-5'}>Harbour</h1>}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {

                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.harbour.fleets as fleet[]).map((fleet: fleet) => (
                                renderFleet(fleet)
                            ))
                        }
                    </div>
                </div>
            </div>
            {/* Third column using 3 */}
            <div className="col-span-3 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the third column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg">
                    {/* Top bar content */}
                    (Third Column)
                </div>
                {/* Content */}
                <div className="p-4">
                    {/* Add content here */}
                    (3 sections)
                </div>
            </div>
        </Layout>
    );
}

export default DashboardPage;
