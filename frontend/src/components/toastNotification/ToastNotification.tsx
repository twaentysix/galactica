import Icon from "../Icon"

type MessageProps = {
    type: string,
    message: string,
}

const ToastNotification = ({type, message}: MessageProps) => {
    switch (type) {
        case "error":
            return (
                <div id="toastNotification" className="rounded-2xl bg-white shadow-lg fixed px-10 py-5 top-5 right-5 animate-toast-in w-2/6 z-50">
                    <div className="absolute -top-4 -right-4">
                        <Icon type="error" size="60" />
                    </div>
                    <h5 className="font-bold text-2xl text-g_dark font-headline mb-2">Error</h5>
                    <p className="text-g_dark">{message}</p>
                </div>
            )
        
        case "warning":
            return (
                <div id="toastNotification" className="rounded-2xl bg-white shadow-lg fixed px-10 py-5 top-5 right-5 animate-toast-in w-2/6 z-50">
                    <div className="absolute -top-4 -right-4">
                        <Icon type="warn" size="60" />
                    </div>
                    <h5 className="font-bold text-2xl text-g_dark font-headline mb-2">Attention</h5>
                    <p className="text-g_dark">{message}</p>
                </div>
            )

        case "info":
            return (
                <div id="toastNotification" className="rounded-2xl bg-white shadow-lg fixed px-10 py-5 top-5 right-5 animate-toast-in w-2/6 z-50">
                    <div className="absolute -top-4 -right-4">
                        <Icon type="success" size="60" />
                    </div>
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