import React, {Component} from 'react';
import {Route, withRouter} from "react-router-dom";
import LazyRoute from 'lazy-route';
import './style.less';
import {Layout} from 'td-ui';
import Sidebar from './sidebar';

const {Sider, Content} = Layout;

class App extends Component {
    render() {
        return (
            <Layout>
                <div className="account-sidebar">
                    <Sidebar/>
                </div>
                <Content>
                    <Route
                        exact
                        path="/"
                        render={props => (
                            <LazyRoute {...props} component={import("./rental/page")}/>
                        )}
                    />
                    <Route
                        exact
                        path="/rental/vehicle"
                        render={props => (
                            <LazyRoute {...props} component={import("./vehicle/page")}/>
                        )}
                    />
                    <Route
                        exact
                        path="/rental/driver"
                        render={props => (
                            <LazyRoute {...props} component={import("./driver/page")}/>
                        )}
                    />
                </Content>
            </Layout>
        );
    }
}

module.exports = withRouter(App);