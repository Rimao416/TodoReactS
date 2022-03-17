import React, { Component } from 'react'
import ReactDom from 'react-dom'
import TodoContextProvider from './contexts/TodoContext'
import {CssBaseLine} from '@material-ui/core'
import TodoTable from './components/TodoTable'
class App extends Component {
  render() {
    return (
      <div>
          <TodoContextProvider>
                  <TodoTable/>
          </TodoContextProvider>
      </div>
    )
  }
}
ReactDom.render(<App/>,document.getElementById('root'))