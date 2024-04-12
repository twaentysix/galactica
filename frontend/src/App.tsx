import { BrowserRouter } from 'react-router-dom'

import './App.css'
import Layout from './components/Layout'
import OurDialog from './components/OurDialog'

function App() {

  return (
    <BrowserRouter>
      <Layout>
        <OurDialog />
      </Layout>
    </BrowserRouter>
  )
}

export default App
