import React from "react";

const Layout = ( props ) => {
    return (
        <div className="container mx-auto px-4">
            <div className="grid grid-cols-12 gap-1">
                <div className="col-span-12 sm:col-span-12 md:col-span-3 lg:col-span-3 xl:col-span-3 2xl:col-span-3">{props.children}</div>
                <div className="col-span-12 sm:col-span-12 md:col-span-3 lg:col-span-3 xl:col-span-3 2xl:col-span-3">{props.children}</div>
                <div className="col-span-12 sm:col-span-12 md:col-span-3 lg:col-span-3 xl:col-span-3 2xl:col-span-3">{props.children}</div>
            </div>
        </div>
    );
};

export default Layout;


