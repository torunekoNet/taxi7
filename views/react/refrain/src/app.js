import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { observer, inject } from 'mobx-react';
import './style.less';
import { Layout, Icon, Dropdown, Menu } from 'td-ui';
import Sidebar from './sidebar';
import TDCIcon from './tdcicon';
import Waiting from './waiting';

const domain = window.geffenDomain || '';
const { Header, Sider, Content } = Layout;
const SIDER_NODE = document.getElementById('refrain-sidebar');
const CONTENT_NODE = document.getElementById('refrain-content');
const WAITING_NODE = document.getElementById('refrain-waiting');

@inject('store')
@observer
export default class App extends Component {
  render() {
    const { realname, collapsed, isWating } = this.props.store;
    CONTENT_NODE.style.display = isWating ? 'none' : 'block';
    WAITING_NODE.style.display = isWating ? 'block' : 'none';
    return [
      <div key="logo" className="refrain-logo">
        <Icon type="bars" 
          className="refrain-logo-collaps"
          onClick={() => {
            this.props.store.setCollapsed(!collapsed);
          }}
        />
        <div className="refrain-header-split"/>
        <a className="refrain-logo-home">
          Tongdun Cloud
        </a>
      </div>,
      <div key="nav" className="refrain-nav">
        <ul>
          <li>
            <span className="refrain-nav-user">
              <TDCIcon type="avatar" />
              {
                realname
              }
            </span>
          </li>
          <li>
            <a href={`${domain}/logout`} className="refrain-nav-logout">
              <Icon type="output" />
            </a>
          </li>
        </ul>
        { ReactDOM.createPortal(
            <Sider
              key="sider"
              trigger={null}
              collapsible
              collapsed={collapsed}
              width={240}
              className="refrain-sidebar"
              style={{ background: '#404040', minHeight: 'calc(100vh - 64px)' }}
              >
              <Sidebar />
            </Sider>,
            SIDER_NODE
          )
        }
        {
          ReactDOM.createPortal(
            <Waiting />,
            WAITING_NODE
          )
        }
      </div>
    ];
  }
}
