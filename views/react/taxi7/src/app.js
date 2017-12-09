import React, { Component } from 'react';
import { Route, withRouter } from "react-router-dom";
import LazyRoute from 'lazy-route';
import './style.less';
import { Layout } from 'td-ui';
import Sidebar from './sidebar';

const { Sider, Content } = Layout;

class App extends Component {
  render() {
    return (
      <Layout>
        <Sider 
          trigger={null}
          width={176}
          className="account-sidebar"
          >
          <Sidebar />
        </Sider>
        <Content>
          <Route
  					exact
  					path="/"
  					render={props => (
  						<LazyRoute {...props} component={import("./application/page")} />
  					)}
  				/>
          <Route
  					exact
  					path="/overview"
  					render={props => (
  						<LazyRoute {...props} component={import("./overview/page")} />
  					)}
  				/>
          <Route
  					exact
  					path="/usermanager"
  					render={props => (
  						<LazyRoute {...props} component={import("./usermanager/page")} />
  					)}
  				/>
          <Route
  					exact
  					path="/groupmanager"
  					render={props => (
  						<LazyRoute {...props} component={import("./groupmanager/page")} />
  					)}
  				/>
          <Route
  					exact
  					path="/policy"
  					render={props => (
  						<LazyRoute {...props} component={import("./policy/page")} />
  					)}
  				/>
        </Content>
      </Layout>
    );
  }
}

module.exports = withRouter(App);