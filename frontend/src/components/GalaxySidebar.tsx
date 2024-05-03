import CustomCard from "@/components/customCard.tsx";
import Icon from "@/components/Icon.tsx";
import {error, galaxy, planet} from "@/lib/types.ts"
import DialogField from "@/components/DialogField.tsx";
import {Label} from "@/components/ui/label.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {Input} from "@/components/ui/input.tsx";
import {useState} from "react";
import ActionButton from "@/components/ActionButton.tsx";

export const getGalaxySidebar = (galaxy: galaxy, reload : any, notification : any) => {
    const [galaxyDialog, setGalaxyDialog] = useState<boolean>(false);
    return (
        <div>
            {
                galaxy.planets.map((planet: planet) => (
                    <CustomCard
                        className={'mb-5'}
                        key={planet.id}
                        backgroundColor="bg-g_planet_gradient"
                        title={planet.name}
                        status={planet.occupied ? "Occupied by " + planet.occupiedBy.username : ''}
                        svg={<Icon type="planet1" size="50"/>}
                    />
                ))
            }
            <ActionButton onClick={() => {setGalaxyDialog(!galaxyDialog)}}>New Base</ActionButton>
            {
                galaxyDialog &&
                    <DialogField>
                        <div id="dialog-headline-wrapper mb-5">
                            <h4 className="text-g_dark text-3xl">Dialog Title</h4>
                        </div>
                        <div id="dialog-body-wrapper">
                            <Label htmlFor="name" className="sr-only">Transporter</Label>
                            <Input
                                type={"text"}
                                placeholder={"Name for your new Base and Planet."}
                                id="name"
                            />
                        </div>
                        <div id="dialog-meta-info" className="mb-5">
                        </div>
                        <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                            <Button onClick={()=>{setGalaxyDialog(!galaxyDialog)}}>Cancel</Button>
                            <Button onClick={
                                    () => {
                                        // @ts-ignore
                                        const name = document.getElementById('name').value

                                        ActionHandler.createBase(galaxy.id, name)
                                            .then((data:any) => {
                                                setGalaxyDialog(!galaxyDialog);
                                                data['error'] === undefined ?  notification({message:'Successfully created new Base!', type:'info'})  : notification({message:(data['error'] as error).message, type:'warning'});
                                                reload();
                                            })
                                    }
                                }>
                                Apply
                            </Button>
                        </div>
                    </DialogField>
            }
        </div>

    )
}
