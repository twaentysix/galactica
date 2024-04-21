import AuthHandler from "@/lib/api/AuthHandler";

const Layout = (props: any) => {
    AuthHandler.register("Amely", 'contact@röseler.de', 'password')
    return (
        <div className="container max-w-full h-screen flex flex-col px-0">
            <div className="bg-gray-900 text-white mb-8">
                {/* Top Bar */}
                <div className="flex items-center justify-between px-8 py-4">
                    <h1 className="text-lg font-bold">Top Bar</h1>
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



