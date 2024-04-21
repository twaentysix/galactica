import { BrowserRouter } from 'react-router-dom'
import './App.css'
import LoginPage from './components/pages/LoginPage';
import DashboardPage from './components/pages/DashboardPage';

function App() {

  let sessionExists = localStorage.setItem("loggedInUser", "Kekw");

  return (
    <BrowserRouter>
      <DashboardPage />
    </BrowserRouter>
  )
}

export default App
