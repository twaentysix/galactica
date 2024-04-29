import Button from "./button"

const DialogField = () => {
    return (
        <div id="dialog-pre-screen" className="absolute bg-g_dark_translucent animate-blur-in h-screen w-screen z-10 flex justify-center items-center">
            <dialog open className="p-10 bg-white rounded-3xl shadow-2xl w-1/3 h-1/3 flex flex-col justify-between">
                <div id="dialog-headline-wrapper mb-5">
                    <h4 className="text-g_dark text-3xl">Dialog Title</h4>
                </div>
                <div id="dialog-body-wrapper">
                    <p className="text-g_dark">Dialog body</p>
                </div>
                <div id="dialog-meta-info" className="mb-5">
                    <span>Here Icons Please</span>
                </div>
                <div id="dialog-button-area" className="flex flex-row gap-2 justify-between items-center w-full">
                    <Button>Cancel</Button>
                    <Button>Apply</Button>
                </div>
            </dialog>
        </div>
    )
}

export default DialogField