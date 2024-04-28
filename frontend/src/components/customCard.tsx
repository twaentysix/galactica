
const CustomCard = (props: any) => {
  const { title, content, svg, button } = props;

  return (
    <div className="relative border rounded-lg p-4 overflow-hidden">
      {/* SVG positioned in the top right corner */}
      <div className="absolute top-0 right-0 mt-2 mr-2">
        {svg}
      </div>
      {/* Card content */}
      <div>
        <h2 className="text-lg font-semibold mb-2">{title}</h2>
        <p className="text-gray-600">{content}</p>
      </div>
      {/* Button */}
      <div>
        {button}
      </div>
    </div>
  );
};

export default CustomCard;

