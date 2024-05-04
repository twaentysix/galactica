import {useState} from "react";
import ActionButton from "@/components/ActionButton.tsx";
import DialogField from "@/components/DialogField.tsx";
import {Label} from "@/components/ui/label.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {error, fleet, idleShips} from "@/lib/types";

type fleetDialog = {
    update : boolean,
    expedition : boolean,
}
export const getFleetSidebar = (fleet:fleet, reload : any, notification : any) => {
    const [fleetDialog, setFleetDialog] = useState<fleetDialog>({update : false, expedition : false});
    const maxShips : idleShips = {
        light_fighter: (fleet.idleShips.light_fighter + fleet.lightFighter),
        heavy_fighter: (fleet.idleShips.heavy_fighter + fleet.heavyFighter),
        transporter: (fleet.idleShips.transporter + fleet.transporter),
        cruiser: (fleet.idleShips.cruiser + fleet.cruiser),
        battleships: (fleet.idleShips.battleships + fleet.battleship),
    }

    return (
        <div className="mt-5">
            <h1>{fleet.name}</h1>
            {fleet.busy && (<h2>Fleet is busy</h2>)}
            <h2>Fleet Strength: <span className={'text-sm'}>{fleet.strength}</span></h2>
            {/* add onclick new dialog for updating fleet*/}
            <ActionButton onClick={() => {setFleetDialog({update : !fleetDialog.update, expedition : false})}}>Update Fleet</ActionButton>
            {fleetDialog.update &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Configure your fleet!</h4>
                    </div>
                    <div id="dialog-body-wrapper">
                        <Label htmlFor="t">Transporter: <span id={'tl'}>{fleet.transporter}</span></Label>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="t" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('tl').innerText = e.currentTarget.value}} 
                                defaultValue={fleet.transporter}
                                min={0}
                                max={maxShips.transporter}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                            />
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">Min {0}</span>
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">Max {maxShips.transporter}</span>
                        </div>
                        
                        <Label htmlFor="lfl">Light Fighter: <span id={'lfl'}>{fleet.lightFighter}</span></Label>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="lf" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('lfl').innerText = e.currentTarget.value}} 
                                defaultValue={fleet.lightFighter}
                                min={0}
                                max={maxShips.light_fighter}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                            />
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">Min {0}</span>
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">Max {maxShips.light_fighter}</span>
                        </div>

                        <Label htmlFor="hf">Heavy Fighter: <span id={'hfl'}>{fleet.heavyFighter}</span></Label>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="hf" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('hfl').innerText = e.currentTarget.value}} 
                                defaultValue={fleet.heavyFighter}
                                min={0}
                                max={maxShips.heavy_fighter}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                            />
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">Min {0}</span>
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">Max {maxShips.heavy_fighter}</span>
                        </div>

                        <Label htmlFor="c">Cruiser: <span id={'cl'}>{fleet.cruiser}</span></Label>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="c" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('cl').innerText = e.currentTarget.value}} 
                                defaultValue={fleet.cruiser}
                                min={0}
                                max={maxShips.cruiser}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                            />
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">Min {0}</span>
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">Max {maxShips.cruiser}</span>
                        </div>

                        <Label htmlFor="b">Battleships: <span id={'bl'}>{fleet.battleship}</span></Label>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="b" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('bl').innerText = e.currentTarget.value}} 
                                defaultValue={fleet.battleship}
                                min={0}
                                max={maxShips.battleships}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" 
                            />
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">Min {0}</span>
                            <span className="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">Max {maxShips.battleships}</span>
                        </div>

                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={()=>{setFleetDialog({update : !fleetDialog.update, expedition : false})}}>Cancel</Button>
                        <Button onClick={
                            () => {
                                // @ts-ignore
                                const lf = document.getElementById('lf').value
                                // @ts-ignore
                                const hf = document.getElementById('hf').value
                                // @ts-ignore
                                const t = document.getElementById('t').value
                                // @ts-ignore
                                const c = document.getElementById('c').value
                                // @ts-ignore
                                const bs = document.getElementById('b').value

                                ActionHandler.updateFleet(fleet.id, lf,hf,c,t,bs)
                                    .then((data:any) => {
                                        setFleetDialog({update : !fleetDialog.update, expedition : false});
                                        data['error'] === undefined ?  notification({message:'Successfully updated Fleet!', type:'info'})  : notification({message:(data['error'] as error).message, type:'warning'});
                                        reload();
                                    })
                            }
                        }>Apply</Button>
                    </div>
                </DialogField>
            }

            {/* add onclick new dialog for starting expeditions */}
            <ActionButton onClick={() => {setFleetDialog({update : false, expedition : !fleetDialog.expedition})}}>Start expedition</ActionButton>
            {fleetDialog.expedition &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Dialog Title</h4>
                    </div>
                    <div id="dialog-body-wrapper">
                        <Label htmlFor="duration">Duration in Minutes: </Label>
                        <input
                            type={"number"}
                            max={100}
                            min={5}
                            step={5}
                            id={'duration'}
                            defaultValue={10}
                       />
                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={()=>{setFleetDialog({update : false, expedition : !fleetDialog.expedition})}}>Cancel</Button>
                        <Button onClick={
                            () => {
                                // @ts-ignore
                                const duration = document.getElementById('duration').value

                                ActionHandler.registerExpedition(fleet.id, duration)
                                    .then((data:any) => {
                                        setFleetDialog({update : false, expedition : !fleetDialog.expedition});
                                        data['error'] === undefined ?  notification({message:'Successfully started Expedition!', type:'info'})  : notification({message:(data['error'] as error).message, type:'warning'});
                                        reload();
                                    })
                            }
                        }>Apply</Button>
                    </div>
                </DialogField>
            }
        </div>

    )
}
