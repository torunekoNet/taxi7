import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {observer, inject} from 'mobx-react';
import './style.less';
import {Layout, Icon, Dropdown, Menu} from 'td-ui';
import Sidebar from './sidebar';
import TDCIcon from './tdcicon';
import Waiting from './waiting';

const domain = window.geffenDomain || '';
const {Sider} = Layout;
const SIDER_NODE = document.getElementById('refrain-sidebar');
const CONTENT_NODE = document.getElementById('refrain-content');
const WAITING_NODE = document.getElementById('refrain-waiting');

@inject('store')
@observer
export default class App extends Component {
    render() {
        const {realname, collapsed, isWating} = this.props.store;
        CONTENT_NODE.style.display = isWating ? 'none' : 'block';
        WAITING_NODE.style.display = isWating ? 'block' : 'none';
        return (
            <div className="refrain-nav">
                <ul>
                    <li>
                        <span className="refrain-nav-user">
                          <TDCIcon type="avatar"/>
                            {
                                realname
                            }
                        </span>
                    </li>
                    <li>
                        <a href={`${domain}/logout`} className="refrain-nav-logout">
                            <Icon type="output"/>
                        </a>
                    </li>
                </ul>
            </div>
        );
    }
}
