import './App.css'
import LoginPage from './components/pages/LoginPage';
import DashboardPage from './components/pages/DashboardPage';

function App() {

  let sessionExists = sessionStorage.getItem("jwt");

  return (
      <div>
        {sessionExists ? <DashboardPage /> : <LoginPage />}
      </div>
  )
}

export default App
