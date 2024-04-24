import { BrowserRouter } from 'react-router-dom'
import './App.css'
import LoginPage from './components/pages/LoginPage';
import DashboardPage from './components/pages/DashboardPage';

function App() {

  let sessionExists = localStorage.getItem("loggedInUser");

  return (
    <BrowserRouter>
      {sessionExists ? <DashboardPage /> : <LoginPage />}
    </BrowserRouter>
  )
}

export default App
