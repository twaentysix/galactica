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
                        <Label htmlFor="t" className="sr-only">Transporter</Label>
                        <input
                            type={"range"}
                            min="0"
                            max={maxShips.transporter}
                            defaultValue={ fleet.transporter }
                            id="t"
                        />
                        <Label htmlFor="lf" className="sr-only">Light Fighter</Label>
                        <input
                            type={"range"}
                            min="0"
                            max={maxShips.light_fighter}
                            defaultValue={ fleet.lightFighter }
                            id="lf"
                        />
                        <Label htmlFor="hf" className="sr-only">Heavy Fighter</Label>
                        <input
                            type={"range"}
                            min="0"
                            max={maxShips.heavy_fighter}
                            defaultValue={ fleet.heavyFighter }
                            id="hf"
                        />
                        <Label htmlFor="c" className="sr-only">Cruiser</Label>
                        <input
                            type={"range"}
                            min="0"
                            max={maxShips.cruiser}
                            defaultValue={ fleet.cruiser }
                            id="c"
                        />
                        <Label htmlFor="bs" className="sr-only">Battleships</Label>
                        <input
                            type={"range"}
                            min="0"
                            max={maxShips.battleships}
                            defaultValue={ fleet.battleship }
                            id="bs"
                        />
                    </div>
                    <div id="dialog-meta-info" className="mb-5">
                        <span>Here Icons Please</span>
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
                                const bs = document.getElementById('bs').value

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
