import DataHandler from "@/lib/api/DataHandler";
import Icon from "../Icon";
import Layout from "../Layout";
import CustomCard from "../customCard";
import { useEffect, useState } from "react";
import {collector, base} from "@/lib/types.ts";

const DashboardPage = (props: any) => {

    const [baseData, setBaseData] = useState<base[]>([])

    const [selectedBase, setSelectedBase] = useState<base>()

    useEffect(() => {
        DataHandler.getBases().then(data => {setBaseData(data); setSelectedBase(data[0]); console.log(selectedBase)});
    }, []);

    const { metals, fuels, gems, medals, bases } = props;

    const changeBase = (base : base) => {
        setSelectedBase(base);
    };

    function renderCollector(collector : collector) {
        switch (collector.type) {
            default:
                return <CustomCard
                    key={collector.id}
                    backgroundColor="bg-g_planet_gradient"
                    title={collector["type"]}
                    status={"Las Updated at: " + new Date(collector.lastCollected).toDateString()}
                    icon={<Icon type="medal" size="20"/>}
                    value={collector["level"]}
                    svg={<Icon type="planet1" size="50"/>}
                />
        }
    }

    return (
        <Layout>
            {/* First column using two grid sections */}
            <div className="col-span-2 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the first column */}
                <div className="bg-g_light h-10 px-4 flex items-center justify-center rounded-t-lg">
                    {/* Top bar content */}
                    <span className="text-g_dark font-headline font-bold">Milkyway</span>
                </div>
                {/* Content */}
                <div className="">
                    <div className="m-4">
                        <p className="text-md font-main font-bold">Bases</p>
                        <div className="flex items-center">
                            <p className="text-sm text-muted mr-2">Total:</p>
                            <p className="text-md font-main font-bold">{bases}</p>
                        </div>
                    </div>
                    {baseData.map((base:base) => (
                            <CustomCard
                                key={base.id}
                                backgroundColor="bg-g_planet_gradient"
                                title={base["name"]}
                                status={"Created at: " + new Date(base["createdAt"]).toDateString() }
                                icon={<Icon type="medal" size="20" />}
                                value={base["level"]}
                                svg={<Icon type="planet1" size="50" />}
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
                        <p className="text-md">{metals}</p>
                        <div><Icon type="fuel" size="15" /></div>
                        <p className="text-md">{fuels}</p>
                        <div><Icon type="gem" size="20" /></div>
                        <p className="text-md">{gems}</p>
                    </div>

                    {/* Right-aligned medals */}
                    <div className="flex items-center pr-4">
                        <div className="mr-2"><Icon type="medal" size="15" /></div>
                        <p className="text-md">{medals}</p>
                    </div>
                </div>
                {/* Content */}
                <div className="p-8">
                    {/* Add content here */}
                    <div className="grid grid-cols-3 gap-8">
                        {
                            baseData[0] && selectedBase &&
                            (selectedBase.collectors as collector[]).map((collector: collector) => (
                                    renderCollector(collector)
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
