import Button from "../button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

import LoginImage from "../../assets/purple_moon_base.jpg";
import Logo from "../../assets/Logo.svg"
import { useState } from "react";

import ToastNotification from "../toastNotification/ToastNotification";
import AuthHandler from "@/lib/api/AuthHandler";

const LoginPage = () => {
    const [notification, setNotification] = useState(false);
    const [errorMessage, setErrorMessage] = useState("");

    const buttonHandler = () => {
        setTimeout(() => setNotification(false), 6000);
    }

    const handleSubmit = (event: any) => {
        event.preventDefault();
        // TODO: Validate form data and create a session using the API

        buttonHandler();

        // @ts-ignore
        const name = document.getElementById('username').value

        // @ts-ignore
        const password = document.getElementById('password').value

        AuthHandler.login(name,password)
            .then(data => {
                if (data["error"] !== undefined) {
                    setErrorMessage(data["error"]["message"])
                    setNotification(true)
                } else {
                    location.reload()
                }
            });
    };

    return (
        <div id="loginScreen" className="lg:flex">
            {notification === true ? <ToastNotification type="error" message={errorMessage}/> : null}
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
                        <p className="">
                            Login to your account
                        </p>    
                    </div>
                    <form onSubmit={handleSubmit}>
                        <div className="flex flex-col gap-5">
                            <div className="">
                                <Label htmlFor="username" className="sr-only">Email</Label>
                                <Input
                                    id="username"
                                    type="name"
                                    placeholder="YouUsername123"
                                    required
                                />
                            </div>
                            <div className="">
                                <div className="">
                                    <Label htmlFor="password" className="sr-only">Password</Label>
                                </div>
                                <Input id="password" type="password" required  placeholder="Your password"/>
                            </div>
                            <Button type="submit">
                                Login
                            </Button>
                        </div>
                    </form>
                    <div className="text-center">
                        Don&apos;t have an account?{" "}
                            <a href="#" className="underline">
                                Sign up
                            </a>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default LoginPage