import "./toastNotification.css"

const ToastNotification = (props: any) => {
    return (
        <div id="toastNotification" className="rounded-xl bg-white shadow-lg fixed px-8 py-3 top-5 right-5 transition-all duration-200 ease-in-out">
            <span className="font-bold text-g_dark">{props.children}</span>
        </div>
    )
}

export default ToastNotification