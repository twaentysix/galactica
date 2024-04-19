const Button = (props: any) => {
  return(
    <button className="rounded-md text-g_dark font-bold bg-g_light_gradient w-100 px-5 py-2 hover:brightness-150 transition-all ease-in-out duration-200">
      {props.children}
    </button>
  );
}

export default Button
