
const CustomCard = (props: any) => {
  const { title, status, icon, value, svg, button, backgroundColor, onClick, className } = props;

  return (
    <div onClick={onClick} className={`relative rounded-lg p-5 h-auto shadow-xl transition-all hover:brightness-150 hover:cursor-pointer hover:scale-105 active:brightness-75 active:scale-100 ${backgroundColor} ${className}`}>
      {/* SVG positioned in the top right corner */}
      <div className="absolute top-0 right-0 -mt-1.5 -mr-1.5 overflow-visible">
        {svg}
      </div>
      {/* Card content */}
      <div className="mb-3">
        <h2 className="text-2xl font-headline font-bold">{title}</h2>
        <div className="mb-4 text-sm font-main font-muted">{status}</div>
        <div className="flex items-center">
          <div className="mr-2">{icon}</div>
          <div className="text-2xl font-headline font-bold">{value}</div>
        </div>
      </div>
      <div>
        {button}
      </div>
    </div>
  );
};

export default CustomCard;
