import DataHandler from "@/lib/api/DataHandler";
import Icon from "../Icon";
import Layout from "../Layout";
import CustomCard from "../customCard";
import { useEffect, useState } from "react";
import {info, collector, base, fleet, galaxy, barracks, error, expedition} from "@/lib/types.ts";
import {renderCollector, renderFleet} from "@/lib/RenderFunctions.tsx";
import ActionSidebar from "../ActionSidebar";
import ToastNotification from "@/components/toastNotification/ToastNotification.tsx";
import ActionButton from "../ActionButton";
import ActionHandler from "@/lib/api/ActionHandler";
import DialogField from "@/components/DialogField.tsx";
import {Label} from "@/components/ui/label.tsx";
import {Input} from "@/components/ui/input.tsx";
import Button from "@/components/button.tsx";

type addFleetDialog = {
    addFleet : boolean
    expeditionNotification : boolean;
}

const DashboardPage = () => {
    const [baseData, setBaseData] = useState<base[]>([])
    const [galaxiesData, setGalaxiesData] = useState<galaxy[]>([])
    const [selectedBase, setSelectedBase] = useState<base>()
    const [starMapActive, setStarMap] = useState<boolean>(true)
    const [actionBarType, setActionBarType] = useState<string>('')
    const [actionBarItem, setActionBarItem] = useState<collector | galaxy | barracks | fleet>()
    const [notification, setNotification] = useState(false);
    const [info, setInfo] = useState<info>({message:'', type:'info'});
    const [dialogs, setDialogs] = useState<addFleetDialog>({addFleet : false, expeditionNotification: false});

    useEffect(() => {
        DataHandler.getBases().then(data => {
            setBaseData(data); data.length > 0 && setSelectedBase(data[0])
        });
        DataHandler.getGalaxies().then(data => {setGalaxiesData(data)});
    }, []);


    const changeBase = (base : base) => {
        starMapActive && setStarMap(false);
        setSelectedBase(base);
        if(base.unseenExpeditions){
            setDialogs({addFleet : dialogs.addFleet, expeditionNotification : true});
        }
    };

     const changeSidebar = (_type:string, item?: collector | galaxy | barracks | fleet | base) => {
         setActionBarType(_type);
         setActionBarItem(item);
    }

    const activateNotification = (info : info) => {
        setInfo(info);
        setNotification(true)
        setTimeout(() => setNotification(false), 4000);
    }

    const reload = () => {
        DataHandler.getBases().then((data : base[]) => {
                setBaseData(data);
                data.length > 0 && setSelectedBase(data[data.findIndex((element:base) => element.id === selectedBase?.id as number)])
        });
        DataHandler.getGalaxies().then(data => {setGalaxiesData(data)});
    }

    const starMapHandler = () => {
        setStarMap(true);
        setSelectedBase(undefined);
    }

    return (
        <Layout>
            {/* First column using two grid sections */}
            <div className="relative col-span-3 bg-g_base_gradient_0 rounded-lg h-[85vh]">
                {/* Top bar for the first column */}
                <div className="bg-g_light absolute top-0 z-30 left-0 w-full h-10 px-4 flex items-center justify-center rounded-t-lg">
                    {/* Top bar content */}
                    <span className="text-g_dark font-headline font-bold">Control Unit</span>
                </div>
                {/* Content */}
                <div className="px-6 py-10 h-full overflow-y-scroll no-scrollbar">
                    <CustomCard
                        className={'mb-10 mt-5'}
                        key={galaxiesData}
                        backgroundColor="bg-g_planet_gradient"
                        title={'Star map'}
                        value={galaxiesData.length}
                        onClick={starMapHandler}
                        icon={<Icon type="galaxy" size="32" />}
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
                            className={`${selectedBase?.id == base.id ? '!shadow-glow mb-5 scale-105 !brightness-150' : 'mb-5'}`}
                            key={base.id}
                            backgroundColor="bg-g_planet_gradient"
                            title={base["name"]}
                            status={<div className="my-3 flex flex-col justify-start"><span>Created:</span><span className="font-headline text-lg font-bold">{new Date(base["createdAt"]).toDateString()}</span></div>}
                            icon={<Icon type="medal" size="20"/>}
                            value={base["level"]}
                            svg={<Icon type="planet1" size="50"/>}
                            onClick={() => changeBase(base)}
                        />
                    ))}

                </div>
            </div>
            {/* Bigger column using 7 */}
            <div className="relative col-span-6 bg-g_base_gradient_0 rounded-lg h-[85vh]">
                <div className="absolute top-0 z-30 left-0 w-full bg-g_light h-10 px-4 flex items-center rounded-t-lg justify-between">
                    {!starMapActive &&
                        <div className="flex items-center gap-6 px-4">
                            <div className="flex gap-2 items-center">
                                <div><Icon type="metal" size="25" /></div>
                                <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.metal}</p>
                            </div>
                            <div className="flex gap-2 items-center">
                                <div><Icon type="fuel" size="15" /></div>
                                <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.gas}</p>
                            </div>
                            <div className="flex gap-2 items-center">
                                <div><Icon type="gem" size="20" /></div>
                                <p className="font-headline font-bold text-g_dark">{selectedBase?.resources.gems}</p>
                            </div>
                        </div>
                    }
                    {!starMapActive &&
                        <div className="flex items-center pr-4">
                            <div className="mr-2"><Icon type="medal" size="15" /></div>
                            <p className="text-md font-headline font-bold text-g_dark">{selectedBase?.level}</p>
                        </div>
                    }
                </div>

                {/* Content */}
                <div className="px-8 py-10 h-full overflow-y-scroll no-scrollbar">
                    {!starMapActive && <h2 className={'my-5 text-4xl'}>{selectedBase?.name}</h2>}
                    {/* Add content here */}
                     <div className="grid grid-cols-1 gap-8 mb-10">
                        {
                            !starMapActive && 
                                <ActionButton 
                                    onClick={() => {ActionHandler.upgradeBase(selectedBase?.id)
                                        .then((data:any) => {
                                            data['error'] === undefined ? activateNotification({message:'Successfully upgraded Base!' , type:'info'}) : activateNotification({message:(data['error'] as error).message, type:'warning'})
                                            reload();
                                        })}}
                                >
                                    Upgrade base
                                    <div className={'flex justify-center items-center gap-2'}  >
                                        <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'metal'} size={'20'}/> {selectedBase?.upgradeCost.metal}</span>
                                        <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'fuel'} size={'16'}/> {selectedBase?.upgradeCost.gas}</span>
                                        <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'gem'} size={'20'}/> {selectedBase?.upgradeCost.gems}</span>
                                    </div>
                                </ActionButton>
                        }
                     </div>
                    {!starMapActive && <h2 className={'mb-5'}>Collectors</h2>}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {
                            starMapActive && galaxiesData.map((galaxy: galaxy) => (
                                <CustomCard
                                    className={''}
                                    key={galaxy.id}
                                    backgroundColor="bg-g_base_gradient_1"
                                    title={galaxy.name}
                                    value={galaxy.planets.length}
                                    onClick={()=>{changeSidebar('galaxy',galaxy)}}
                                    icon={<Icon type="planet1" size="30" />}
                                />
                            ))}
                        {
                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.collectors as collector[]).map((collector: collector) => (
                                renderCollector(collector, ()=>{changeSidebar('collector',collector)})
                            ))
                        }
                    </div>
                    {!starMapActive && (
                        <div className={'mb-5'}>
                            <h2>Harbour</h2>
                            <div className="flex flex-col gap-1 my-5">
                                <span>Total Amount of Ships:</span>
                                <span className="font-headline font-bold">{selectedBase?.harbour.totalAmountShips}</span>
                            </div>
                        </div>
                    )}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {

                            baseData[0] && selectedBase && !starMapActive &&
                            (selectedBase.harbour.fleets as fleet[]).map((fleet: fleet) => (
                                renderFleet(fleet, ()=>{changeSidebar('fleet',fleet)})
                            ))
                        }
                        {!starMapActive && <ActionButton onClick={() => {setDialogs({addFleet : !dialogs.addFleet, expeditionNotification : dialogs.expeditionNotification})}}>Create fleet</ActionButton>}
                        {
                            dialogs.addFleet &&
                            <DialogField>
                                <div id="dialog-headline-wrapper mb-5">
                                    <h4 className="text-g_dark text-3xl">Create fleet</h4>
                                </div>
                                <div id="dialog-body-wrapper">
                                    <Label htmlFor="name" className="sr-only">Name of the fleet</Label>
                                    <Input id={'name'} placeholder={'Name of the fleet'} type={'text'}></Input>
                                </div>
                                <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                                    <Button onClick={()=>{setDialogs({addFleet : !dialogs.addFleet, expeditionNotification : dialogs.expeditionNotification})}}>Cancel</Button>
                                    <Button onClick={
                                        () => {
                                            // @ts-ignore
                                            const name = document.getElementById('name').value

                                            ActionHandler.createFleet(selectedBase?.harbour.id, name)
                                                .then((data:any) => {
                                                    reload();
                                                    setDialogs({addFleet : !dialogs.addFleet, expeditionNotification : dialogs.expeditionNotification});
                                                    data['error'] === undefined ?  activateNotification({message:'Successfully built new Ships!', type:'info'})  : activateNotification({message:(data['error'] as error).message, type:'warning'});
                                                })
                                        }
                                    }>
                                        Apply
                                    </Button>
                                </div>
                            </DialogField>
                        }
                    </div>
                    {!starMapActive && <h2 className={'mb-5'}>Barracks</h2>}
                    <div className="grid grid-cols-3 gap-8 mb-10">
                        {
                            !starMapActive &&
                            <CustomCard
                                className={'mb-5'}
                                key={'barracks'}
                                backgroundColor="bg-g_base_gradient_1"
                                title={'Baracks'}
                                onClick={() => {changeSidebar('barracks', selectedBase)}}
                            />
                        }
                    </div>
                </div>
            </div>
            {/* Third column using 3 */}
            <div className="col-span-3 bg-g_base_gradient_0 rounded-lg relative h-[85vh]">
                {/* Top bar for the third column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg justify-center absolute top-0 z-30 left-0 w-full">
                        <span className="text-g_dark font-headline font-bold">Action Unit</span>
                </div>
                {/* Content */}
                <div className="px-4 py-10 h-full overflow-y-scroll no-scrollbar">
                    {/* Add content here */}
                    <ActionSidebar
                        type={actionBarType}
                        item={actionBarItem}
                        reload={ reload }
                        notification = {activateNotification}
                    />
                </div>
            </div>
            {notification ? <ToastNotification type={info.type} message={info.message}/> : null}
            {
                dialogs.expeditionNotification &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Alert: Your fleets are back!</h4>
                    </div>
                    <div id="dialog-body-wrapper">
                        <Label htmlFor="name" className="sr-only">Alert: Your fleets are back!</Label>
                        {
                            selectedBase?.unseenExpeditions && selectedBase?.unseenExpeditions.map((expedition : expedition) => (
                                <div>
                                    {expedition.battle &&
                                        <div className="flex flex-col gap-5">
                                            <div className="flex flex-col">
                                                <span className="text-g_dark">You've</span>
                                                {expedition.battle.won && <span className="text-3xl font-headline text-g_green font-bold">won</span>}
                                                {!expedition.battle.won && <span className="text-3xl font-headline text-g_red font-bold">lost</span>}
                                            </div>
                                            <div className="flex flex-col justify-between items-center gap-3">

                                            </div>
                                            <div className="flex flex-col gap-1">
                                                <span className="text-g_dark">You were attacked by:</span>
                                                <span className="font-headline text-g_dark font-bold text-lg">{expedition.battle.opponent}</span>
                                            </div>
                                            <div className="flex flex-col gap-1">
                                                <span className="text-g_dark">Fleet loss:</span>
                                                <span className="font-headline text-g_dark font-bold text-lg">{expedition.battle.lostShips}</span>
                                            </div>
                                            {
                                                expedition.battle.won && (
                                                    <div className="flex flex-col gap-2">
                                                        <div className="flex flex-row justify-between w-28">
                                                            <Icon type="metal" size="24" />
                                                            <span className="font-headline text-g_dark font-bold text-2xl">{expedition.metal}</span>
                                                        </div>
                                                        <div className="flex flex-row justify-between w-28">
                                                            <Icon type="fuel" size="16" />
                                                            <span className="font-headline text-g_dark font-bold text-2xl">{expedition.gas}</span>
                                                        </div>
                                                        <div className="flex flex-row justify-between w-28">
                                                            <Icon type="gem" size="24" />
                                                            <span className="font-headline text-g_dark font-bold text-2xl">{expedition.gems}</span>
                                                        </div>
                                                    </div>
                                                )
                                            }
                                        </div>
                                    }
                                    {!expedition.battle &&
                                        <div className="flex flex-col gap-2">
                                            <div className="mb-5">
                                                <h4 className="text-g_dark">There was no battle, however you've gained</h4>
                                            </div>
                                            <div className="flex flex-row justify-between w-28">
                                                <Icon type="metal" size="24" />
                                                <span className="font-headline text-g_dark font-bold text-2xl">{expedition.metal}</span>
                                            </div>
                                            <div className="flex flex-row justify-between w-28">
                                                <Icon type="fuel" size="16" />
                                                <span className="font-headline text-g_dark font-bold text-2xl">{expedition.gas}</span>
                                            </div>
                                            <div className="flex flex-row justify-between w-28">
                                                <Icon type="gem" size="24" />
                                                <span className="font-headline text-g_dark font-bold text-2xl">{expedition.gems}</span>
                                            </div>
                                        </div>
                                    }
                                </div>
                            ))
                        }
                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={()=>{reload(); setDialogs({addFleet : dialogs.addFleet, expeditionNotification : !dialogs.expeditionNotification})}}>Continue</Button>
                    </div>
                </DialogField>
            }
        </Layout>
    );
}

export default DashboardPage;
