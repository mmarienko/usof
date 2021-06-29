import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from 'react-router-dom';

import DefaultLayout from './layouts/DefaultLayout';
import Home from './pages/Home';
import Profile from './pages/Profile';
import Categories from './pages/Categories';
import Posts from './pages/Posts';
import Sponsor from './pages/Sponsor';
import About from './pages/About';

import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

const theme = createMuiTheme({
    palette: {
        primary: {
            main: '#212121'
        },
        secondary: {
            main: '#ffc400'
        }
    }
});

const App = () => {
    return (
        <MuiThemeProvider theme={theme}>
            <Router>
                <DefaultLayout>
                    <Switch>
                        <Route exact path="/">
                            <Home />
                        </Route>
                        <Route path="/posts">
                            <Posts />
                        </Route>
                        <Route path="/profile">
                            <Profile />
                        </Route>
                        <Route path="/about">
                            <About />
                        </Route>
                        <Route path="/sponsor">
                            <Sponsor />
                        </Route>
                        <Route path="/categories">
                            <Categories />
                        </Route>
                    </Switch>
                </DefaultLayout>
            </Router>
        </MuiThemeProvider>
    );
}

export default App;