const Button = (props: any) => {
  return (
    <button onClick={props.onClick} className="flex items-center gap-2 justify-center rounded-md border-g_light shadow-xl text-g_dark font-bold bg-g_light_gradient w-100 px-5 py-2 hover:brightness-150 transition-all ease-in-out duration-200 hover:scale-105 active:brightness-75 active:scale-100">
      {props.children}
    </button>
  );
}

export default Button
