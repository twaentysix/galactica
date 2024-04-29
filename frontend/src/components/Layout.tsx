
import Logo from "../assets/logo-dashboard.svg";

const Layout = (props: any) => {
    return (
        <div className="container max-w-full h-screen flex flex-col px-0 bg-g_background">
            <div className="bg-gray-900 text-white mb-8">
                {/* Top Bar */}
                <div className="flex items-center justify-between px-8 py-4 bg-g_background">
                    <img src={Logo} alt="Logo" />
                    {/* Add your top bar content here */}
                </div>
            </div>
            <div className="flex-1">
                <div className="grid grid-cols-12 gap-4 h-full px-4">
                    {props.children}
                </div>
            </div>
            <div className="mb-8"></div>
        </div>
    );
};

export default Layout;



