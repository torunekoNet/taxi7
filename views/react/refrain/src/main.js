import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'mobx-react';
import 'whatwg-fetch';
import moment from 'moment';
import 'moment/locale/zh-cn';
import AppStore from './store';
import App from './app';
moment.locale('zh-cn');

const MOUNT_NODE = document.getElementById('refrain');

const store = new AppStore();
if (__DEV__) {
  window.store = store;
}

window.setSidebarKey = key => {
  store.setSelectedKey(key);
}

ReactDOM.render((
  <Provider store={store}>
    <App />
  </Provider>
), MOUNT_NODE);