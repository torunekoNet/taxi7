import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'mobx-react';
import { HashRouter as Router } from 'react-router-dom';
import 'whatwg-fetch';
import moment from 'moment';
import 'moment/locale/zh-cn';
import stores from './stores';
import App from './app';
moment.locale('zh-cn');

const MOUNT_NODE = document.getElementById('refrain-content');

if (__DEV__) {
  window.accountStores = stores;
}

ReactDOM.render(
  <Router>
    <Provider {...stores}>
      <App />
    </Provider>
  </Router>,
  MOUNT_NODE
)