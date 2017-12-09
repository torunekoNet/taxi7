import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Menu, Tooltip } from 'td-ui';
import Icon from './tdcicon';

const Item = Menu.Item;

@inject('store')
@observer
export default class Sidebar extends Component {
  render() {
    const { menus, collapsed, selectedKey } = this.props.store;
    return (
      <Menu
        style={{
          width: collapsed ? 64 : 240,
          borderRight: '1px solid #eee'
        }}
        selectedKeys={[selectedKey]}
        onSelect={selectedKeys => {
          if (selectedKeys.length) {
            const selectedMenu = this.props.store.setSelectedKey(selectedKeys[0]);
            if (selectedMenu.target) {
              window.location.replace(selectedMenu.target);
            }
          }
        }}
        theme="dark"
        >
        {
          menus.map(item => (
            <Item key={item.key}>
              {
                collapsed ? <Tooltip placement="right" content={item.display}>
                  <Icon type={item.key}/>
                </Tooltip> : <Icon type={item.key}/>
              }
              {
                !collapsed && <span>{item.display}</span>
              }
            </Item>
          ))
        }
      </Menu>
    );
  }
}