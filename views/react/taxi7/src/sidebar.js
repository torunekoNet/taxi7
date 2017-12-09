import React, { Component } from 'react';
import { withRouter, Link } from "react-router-dom";
import { Menu } from 'td-ui';
import Icon from './tdcicon';

const ItemGroup = Menu.ItemGroup;
const Item = Menu.Item;
const menus = [{
  key: 'dashboard',
  display: '仪表盘',
  items: [{
    key: 'app',
    display: '应用总览',
    path: '/',
    icon: 'application'
  }]
}, {
  key: 'am',
  display: '访问控制',
  items: [{
    key: 'overview',
    display: '概览',
    path: '/overview',
    icon: 'overview'
  }, {
    key: 'usermanager',
    display: '用户管理',
    path: '/usermanager',
    icon: 'user'
  }, {
    key: 'groupmanager',
    display: '群组管理',
    path: '/groupmanager',
    icon: 'usergroup'
  }, {
    key: 'policy',
    display: '授权策略',
    path: '/policy',
    icon: 'authorization'
  }]
}];

class Sidebar extends Component {
  render() {
    const { location } = this.props;
    const selectedKeys = [];
    menus.some(group => {
      const menu = group.items.find(item => item.path == location.pathname);
      if (menu) {
        selectedKeys.push(menu.key);
        return true;
      }
    });
    return (
      <Menu
        width={176}
        selectedKeys={selectedKeys}
        >
        {
          menus.map(group => (
            <ItemGroup key={group.key} title={group.display}>
              {
                group.items.map(item => (
                  <Item key={item.key}>
                    <Link to={item.path}>
                      <Icon type={item.icon} style={{ float: 'left', marginRight: 10, fontSize: 20 }}/>
                      {item.display}
                    </Link>
                  </Item>
                ))
              }
            </ItemGroup>
          ))
        }
      </Menu>
    );
  }
}

module.exports = withRouter(Sidebar);