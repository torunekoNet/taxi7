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
                        path="/driver"
                        render={props => (
                            <LazyRoute {...props} component={import("./driver/page")}/>
                        )}
                    />
                    <Route
                        exact
                        path="/statistics"
                        render={props => (
                            <LazyRoute {...props} component={import("./statistics/page")}/>
                        )}
                    />
                </Content>
            </Layout>
        );
    }
}

module.exports = withRouter(App);