import "./toastNotification.css"

type MessageProps = {
    type: string,
    message: string,
}

const ToastNotification = ({type, message}: MessageProps) => {
    switch (type) {
        case "error":
            return (
                <div id="toastNotification" className="rounded-xl bg-white shadow-lg fixed px-8 py-3 top-5 right-5 transition-all duration-200 ease-in-out">
                    <h5 className="font-bold text-2xl text-red font-headline mb-2">Error</h5>
                    <p className="text-g_dark">{message}</p>
                </div>
            )
        
        case "warning":
            return (
                <div id="toastNotification" className="rounded-xl bg-white shadow-lg fixed px-8 py-3 top-5 right-5 transition-all duration-200 ease-in-out">
                    <h5 className="font-bold text-2xl text-g_dark font-headline">Attention</h5>
                    <p className="text-g_dark">{message}</p>
                </div>
            )

        case "info":
            return (
                <div id="toastNotification" className="rounded-xl bg-white shadow-lg fixed px-8 py-3 top-5 right-5 transition-all duration-200 ease-in-out">
                    <h5 className="font-bold text-2xl text-g_dark font-headline mb-2">Info</h5>
                    <p className="text-g_dark">{message}</p>
                </div>
            )

        default:
            console.error("No type given. <ToastNotification /> won't be rendered");
            return null;
    }
}

export default ToastNotification