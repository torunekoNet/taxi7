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
                            <LazyRoute {...props} component={import("./product/page2")}/>
                        )}
                    />
                    <Route
                        exact
                        path="/product"
                        render={props => (
                            <LazyRoute {...props} component={import("./product/page2")}/>
                        )}
                    />
                    <Route
                        exact
                        path="/product/assembly"
                        render={props => (
                            <LazyRoute {...props} component={import("./assembly/page")}/>
                        )}
                    />
                </Content>
            </Layout>
        );
    }
}

module.exports = withRouter(App);