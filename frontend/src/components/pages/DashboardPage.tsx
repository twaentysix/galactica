
const DashboardPage = () => {
    return (
        <>
            <div className="bg-gray-900 text-white">
                {/* Top Bar */}
                <div className="flex items-center justify-between px-8 py-4">
                    <h1 className="text-lg font-bold">Top Bar</h1>
                    {/* Add your top bar content here */}
                </div>
            </div>

            <div className="container mx-auto mt-8 px-8">
                {/* Grid */}
                <div className="grid grid-cols-12 gap-8">
                    {/* First column using two grid sections */}
                    <div className="col-span-2 bg-gray-200 p-4">
                        {/* First section */}
                        <div className="mb-8">
                            {/* Add content here */}
                            First Column (2 sections)
                        </div>
                        {/* Second section */}
                        <div>
                            {/* Add content here */}
                            First Column (2 sections)
                        </div>
                    </div>
                    {/* Bigger column using 7 */}
                    <div className="col-span-7 bg-gray-300 p-4">
                        {/* Add content here */}
                        Second Column (7 sections)
                    </div>
                    {/* Third column using 3 */}
                    <div className="col-span-3 bg-gray-400 p-4">
                        {/* Add content here */}
                        Third Column (3 sections)
                    </div>
                </div>
            </div>
        </>
    );
}

export default DashboardPage;
