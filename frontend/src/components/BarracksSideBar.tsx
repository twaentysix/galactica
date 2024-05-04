import {useState} from "react";
import ActionButton from "@/components/ActionButton.tsx";
import DialogField from "@/components/DialogField.tsx";
import {Label} from "@/components/ui/label.tsx";
import {Input} from "@/components/ui/input.tsx";
import Button from "@/components/button.tsx";
import ActionHandler from "@/lib/api/ActionHandler";
import {error, base} from "@/lib/types.ts";

type barracksDialog = {
    buildShips : boolean
}

export const getBarracksSidebar = (base : base, reload : any, notification : any) => {
    const [barracksDialog, setBarracksDialog] = useState<barracksDialog>({buildShips : false});

    return (
        <div>
            <ActionButton onClick={() => {setBarracksDialog({buildShips : !barracksDialog.buildShips})}}>Build Ships</ActionButton>
            {
                barracksDialog.buildShips &&
                <DialogField>
                    <div id="dialog-headline-wrapper mb-5">
                        <h4 className="text-g_dark text-3xl">Configure your fleet</h4>
                    </div>
                    <div id="dialog-body-wrapper">
                        <select id="type">
                            <option value="transporter">Transporter</option>
                            <option value="light_fighter">Light Fighter</option>
                            <option value="heavy_fighter">Heavy Fighter</option>
                            <option value="cruiser">Cruiser</option>
                            <option value="battleships">Battleships</option>
                        </select>
                        <Label htmlFor="name" className="sr-only">Amount of Ships: </Label>
                        <Input
                            type={"amount"}
                            defaultValue={5}
                            id="amount"
                        />
                    </div>
                    <div id="dialog-meta-info" className="mb-5">
                    </div>
                    <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                        <Button onClick={()=>{setBarracksDialog({buildShips : !barracksDialog.buildShips})}}>Cancel</Button>
                        <Button onClick={
                            () => {
                                // @ts-ignore
                                const type = document.getElementById('type').value
                                // @ts-ignore
                                const amount = document.getElementById('amount').value

                                ActionHandler.buildShips(base.id, amount, type)
                                    .then((data:any) => {
                                        reload();
                                        setBarracksDialog({buildShips : !barracksDialog.buildShips});
                                        data['error'] === undefined ?  notification({message:'Successfully built new Ships!', type:'info'})  : notification({message:(data['error'] as error).message, type:'warning'});
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