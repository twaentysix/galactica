
const CustomCard = (props: any) => {
  const { title, status, icon, value, svg, button, backgroundColor } = props;

  return (
    <div className={`relative rounded-lg p-4 h-auto ${backgroundColor}`}>
      {/* SVG positioned in the top right corner */}
      <div className="absolute top-0 right-0 -mt-1.5 -mr-1.5 overflow-visible">
        {svg}
      </div>
      {/* Card content */}
      <div className="mb-4">
        <h2 className="text-lg font-headline font-bold">{title}</h2>
        <p className="mb-4 text-sm font-main font-muted">{status}</p>
        <div className="flex items-center">
          <div className="mr-2">{icon}</div>
          <p className="text-2xl font-headline font-bold">{value}</p>
        </div>
      </div>
      <div>
        {button}
      </div>
    </div>
  );
};

export default CustomCard;
