import {useState} from "react";
import ActionButton from "@/components/ActionButton.tsx";
import DialogField from "@/components/DialogField.tsx";
import {Label} from "@/components/ui/label.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {error, fleet, idleShips} from "@/lib/types";
import Icon from "@/components/Icon.tsx";

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
            <div className={`my-3 flex flex-col justify-start`}>
                <span>Fleet strength:</span>
                <span className="font-headline text-lg font-bold">{fleet.strength}</span>
            </div>
            {fleet.expedition &&
                <div>
                    <div className={`my-3 flex flex-col justify-start`}>
                        <span className={'font-headline text-2xl font-bold'}>Current Expedition</span>
                        <span>Time left:</span>
                        <span className="font-headline text-lg font-bold">{fleet.expedition.timeLeft} Min.</span>
                        <div className={`my-3 flex flex-col justify-start gap-1`}>
                            <span >Expected resource outcome</span>
                            <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'metal'} size={'20'} /> {fleet.expedition.metal}</span>
                            <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'fuel'} size={'16'} /> {fleet.expedition.gas}</span>
                            <span className="font-headline text-lg font-bold flex items-center gap-2"><Icon type={'gem'} size={'20'} /> {fleet.expedition.gems}</span>
                        </div>
                    </div>
                </div>
            }
            {/* add onclick new dialog for updating fleet*/}
            <ActionButton
                className={`${fleet.busy ? 'grayscale pointer-events-none cursor-not-allowed opacity-25' : ''}`}
                onClick={() => {
                    setFleetDialog({update: !fleetDialog.update, expedition: false})
                }}>{fleet.busy ? `Unable to upgrade due to an expedition` : `Set up fleet`}</ActionButton>
            {fleetDialog.update &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Build your ships ..</h4>
                    </div>
                    <div id="dialog-body-wrapper">

                        <div className="flex gap-2 items-center justify-start">
                            <Label htmlFor="t">Transporter: <span className="font-headline font-bold text-g_purple text-2xl" id={'tl'}>{fleet.transporter}</span></Label>
                            <span className="font-headline font-bold text-g_dark text-2xl"> / {maxShips.transporter}</span>
                        </div>
                        <div className="relative mb-6">
                            <input id="t" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('tl').innerText = e.currentTarget.value
                            }}
                                   defaultValue={fleet.transporter}
                                   min={0}
                                   max={maxShips.transporter}
                                   className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            />
                        </div>

                        <div className="flex gap-2 items-center justify-start">
                            <Label htmlFor="lf">Light Fighter: <span className="font-headline font-bold text-g_purple text-2xl" id={'lfl'}>{fleet.lightFighter}</span></Label>
                            <span className="font-headline font-bold text-g_dark text-2xl"> / {maxShips.light_fighter}</span>
                        </div>
                        <div className="relative mb-6">
                            <input id="lf" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('lfl').innerText = e.currentTarget.value
                            }}
                                   defaultValue={fleet.lightFighter}
                                   min={0}
                                   max={maxShips.light_fighter}
                                   className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            />
                        </div>

                        <div className="flex gap-2 items-center justify-start">
                            <Label htmlFor="hf">Heavy Fighter: <span className="font-headline font-bold text-g_purple text-2xl" id={'hfl'}>{fleet.heavyFighter}</span></Label>
                            <span className="font-headline font-bold text-g_dark text-2xl"> / {maxShips.heavy_fighter}</span>
                        </div>
                        <div className="relative mb-6">
                            <input id="hf" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('hfl').innerText = e.currentTarget.value
                            }}
                                   defaultValue={fleet.heavyFighter}
                                   min={0}
                                   max={maxShips.heavy_fighter}
                                   className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            />
                        </div>

                        <div className="flex gap-2 items-center justify-start">
                            <Label htmlFor="c">Cruiser: <span className="font-headline font-bold text-g_purple text-2xl" id={'cl'}>{fleet.cruiser}</span></Label>
                            <span className="font-headline font-bold text-g_dark text-2xl"> / {maxShips.cruiser}</span>
                        </div>
                        <div className="relative mb-6">
                            <input id="c" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('cl').innerText = e.currentTarget.value
                            }}
                                   defaultValue={fleet.cruiser}
                                   min={0}
                                   max={maxShips.cruiser}
                                   className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            />
                        </div>

                        <div className="flex gap-2 items-center justify-start">
                            <Label htmlFor="b">Battleships: <span className="font-headline font-bold text-g_purple text-2xl" id={'bl'}>{fleet.battleship}</span></Label>
                            <span className="font-headline font-bold text-g_dark text-2xl"> / {maxShips.battleships}</span>
                        </div>
                        {/* <Slider id="t" defaultValue={[fleet.transporter]} min={0} max={maxShips.transporter} step={1} /> */}
                        <div className="relative mb-6">
                            <input id="b" type="range" onChange={(e) => {
                                // @ts-ignore 
                                document.getElementById('bl').innerText = e.currentTarget.value
                            }}
                                   defaultValue={fleet.battleship}
                                   min={0}
                                   max={maxShips.battleships}
                                   className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            />
                        </div>

                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={() => {
                            setFleetDialog({update: !fleetDialog.update, expedition: false})
                        }}>Cancel</Button>
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

                                ActionHandler.updateFleet(fleet.id, lf, hf, c, t, bs)
                                    .then((data: any) => {
                                        setFleetDialog({update: !fleetDialog.update, expedition: false});
                                        data['error'] === undefined ? notification({
                                            message: 'Successfully updated Fleet!',
                                            type: 'info'
                                        }) : notification({message: (data['error'] as error).message, type: 'warning'});
                                        reload();
                                    })
                            }
                        }>Apply</Button>
                    </div>
                </DialogField>
            }

            {/* add onclick new dialog for starting expeditions */}
            <ActionButton className={`${fleet.busy ? 'grayscale pointer-events-none cursor-not-allowed opacity-25' : ''}`} onClick={() => {
                setFleetDialog({update: false, expedition: !fleetDialog.expedition})
            }}>{fleet.busy ? `Fleet is already on expedition` : `Start expedition`}</ActionButton>
            {fleetDialog.expedition &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Start the expedition</h4>
                    </div>
                    <div id="dialog-body-wrapper">
                        <Label htmlFor="duration">Duration in minutes: </Label>
                        <input
                            type={"number"}
                            className="bg-g_light shadow-xl p-3 w-full font-sans rounded-xl my-2"
                            max={100}
                            min={5}
                            step={5}
                            id={'duration'}
                            defaultValue={10}
                        />
                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={() => {
                            setFleetDialog({update: false, expedition: !fleetDialog.expedition})
                        }}>Cancel</Button>
                        <Button onClick={
                            () => {
                                // @ts-ignore
                                const duration = document.getElementById('duration').value

                                ActionHandler.registerExpedition(fleet.id, duration)
                                    .then((data: any) => {
                                        setFleetDialog({update: false, expedition: !fleetDialog.expedition});
                                        data['error'] === undefined ? notification({
                                            message: 'Successfully started Expedition!',
                                            type: 'info'
                                        }) : notification({message: (data['error'] as error).message, type: 'warning'});
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
