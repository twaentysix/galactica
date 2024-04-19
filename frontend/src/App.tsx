import { BrowserRouter } from 'react-router-dom'
import './App.css'
// import Layout from './components/Layout'
// import OurDialog from './components/OurDialog'

import Button from './components/button'
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"

import LoginImage from "./assets/purple_moon_base.jpg"; 

function App() {

  return (
    <BrowserRouter>
    <div className="lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
      <div className="hidden bg-muted lg:block">
        <img
          src={LoginImage}
          alt="of space"
          width="1920"
          height="1080"
          className="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
        />
      </div>
      <div className="flex items-center justify-center py-12 bg-g_base_gradient_0">
        <div className="mx-auto grid w-[350px] gap-6">
          <div className="grid gap-2 text-center">
            <h1>Welcome to Galactica</h1>
            <p className="text-muted-foreground">
              Login to your account
            </p>
          </div>
          <div className="grid gap-4">
            <div className="grid gap-2">
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                type="email"
                placeholder="m@example.com"
                required
              />
            </div>
            <div className="grid gap-2">
              <div className="flex items-center">
                <Label htmlFor="password">Password</Label>
              </div>
              <Input id="password" type="password" required />
            </div>
            <Button type="submit" onclick={loginHandler}>
              Login
            </Button>
          </div>
          <div className="mt-4 text-center text-sm">
            Don&apos;t have an account?{" "}
            <a href="#" className="underline">
              Sign up
            </a>
          </div>
        </div>
      </div>
    </div>
    </BrowserRouter>
  )
}

const loginHandler = () => {
  // TODO: Create LoginHandler
}

export default App
