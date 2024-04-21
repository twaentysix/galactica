import Layout from "../Layout";

const DashboardPage = () => {
    return (
        <Layout>
            {/* First column using two grid sections */}
            <div className="col-span-2 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the first column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg">
                    {/* Top bar content */}
                    (First Column)
                </div>
                {/* Content */}
                <div className="p-4">
                    {/* Add content here */}
                    (2 sections)
                </div>
            </div>
            {/* Bigger column using 7 */}
            <div className="col-span-7 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the second column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg">
                    {/* Top bar content */}
                    (Second Column)
                </div>
                {/* Content */}
                <div className="p-4">
                    {/* Add content here */}
                    (7 sections)
                </div>
            </div>
            {/* Third column using 3 */}
            <div className="col-span-3 bg-g_base_gradient_0 rounded-lg">
                {/* Top bar for the third column */}
                <div className="bg-g_light h-10 px-4 flex items-center rounded-t-lg">
                    {/* Top bar content */}
                    (Third Column)
                </div>
                {/* Content */}
                <div className="p-4">
                    {/* Add content here */}
                    (3 sections)
                </div>
            </div>
        </Layout>
    );
}

export default DashboardPage;
