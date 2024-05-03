import Button from "../button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

import LoginImage from "../../assets/purple_moon_base.jpg";
import Logo from "../../assets/Logo.svg"
import { useState } from "react";

import ToastNotification from "../toastNotification/ToastNotification";
import AuthHandler from "@/lib/api/AuthHandler";
import {info} from "@/lib/types.ts";

const LoginPage = () => {
    const [notification, setNotification] = useState(false);
    const [info, setInfo] = useState<info>({message:'', type:'info'});
    const [register, setRegister] = useState(false);

    const buttonHandler = () => {
        setTimeout(() => setNotification(false), 6000);
    }

    const handleSubmit = (event: any) => {
        event.preventDefault();

        // @ts-ignore
        const name: any = document.getElementById('username').value

        // @ts-ignore
        const password: any = document.getElementById('password').value

        if(!register) {
            AuthHandler.login(name, password)
                .then(data => {
                    if (data["error"] !== undefined) {
                        setInfo({message:data["error"]["message"], type:'warning'})
                        setNotification(true)
                        buttonHandler()
                    } else {
                        location.reload()
                    }
                });
        }else{
            // @ts-ignore
            const email: any = document.getElementById('email').value
            AuthHandler.register(name, email, password)
                .then(data => {
                    if (data["error"] !== undefined) {
                        setInfo({message:data["error"]["message"], type:'warning'});
                        setNotification(true);
                        buttonHandler();
                    } else {
                        setInfo({message : 'Successfully registered new Account', type:'info'});
                        setNotification(true);
                        buttonHandler();
                        setRegister(false);
                    }
                });
        }
    };

    return (
        <div id="loginScreen" className="lg:flex">
            {notification ? <ToastNotification type={info.type} message={info.message}/> : null}
            <div className="hidden lg:block lg:w-2/3 h-dvh overflow-y-hidden">
                <img
                    src={LoginImage}
                    alt="Moon base of Galactica"
                    className="animate-blur-in"
                />
            </div>
            <div className="flex items-center justify-center py-12 bg-g_base_gradient_0 lg:w-1/3 lg:h-dvh">
                <div className="flex flex-col gap-10">
                    <div className="flex justify-center items-center flex-col gap-5">
                        <div className="py-20">
                            <img src={Logo} alt="Logo Galactica" />
                        </div>
                        <h1>Welcome to Galactica</h1>

                        {
                            !register &&
                                <p className="">
                                    Login to your account
                                </p>
                        }
                        {
                            register &&
                            <p className="">
                                Register an account
                            </p>
                        }
                    </div>
                    <form onSubmit={handleSubmit}>
                        <div className="flex flex-col gap-5">
                            <div className="">
                                <Label htmlFor="username" className="sr-only">Email</Label>
                                <Input
                                    id="username"
                                    type="name"
                                    placeholder="Your username"
                                    required
                                />
                            </div>
                            {register &&
                                <div className="">
                                    <div className="">
                                        <Label htmlFor="email" className="sr-only">Email</Label>
                                    </div>
                                    <Input id="email" type="email" required placeholder="Your email"/>
                                </div>
                            }
                            <div className="">
                                <div className="">
                                    <Label htmlFor="password" className="sr-only">Password</Label>
                                </div>
                                <Input id="password" type="password" required  placeholder="Your password"/>
                            </div>
                                {
                                    !register &&
                                    <Button type="submit">
                                        Login
                                    </Button>
                                }
                                {
                                    register &&
                                    <Button type="submit">
                                        Register
                                    </Button>
                                }
                        </div>
                    </form>
                    {
                        !register &&
                            <div className="text-center">
                                Don&apos;t have an account?{" "}
                                <a href="#" onClick={() => {setRegister(true)}} className="underline">
                                        Sign up
                                    </a>
                            </div>
                    }
                    {
                        register &&
                        <div className="text-center">
                            Already have an account?{" "}
                            <a href="#" onClick={() => {setRegister(false)}} className="underline">
                                Login
                            </a>
                        </div>
                    }
                </div>
            </div>
        </div>
    )
}

export default LoginPage