import React, {Component} from 'react';
import {withRouter, Link} from "react-router-dom";
import {Menu} from 'td-ui';

const Item = Menu.Item;
const menus = [{
    key: 'gateway',
    display: '配件管理',
    path: '/'
}, {
    key: 'data',
    display: '流水数据',
    path: '/product/assembly'
}];

class Sidebar extends Component {
    render() {
        const {location} = this.props;
        const selectedKeys = [];
        const menu = menus.find(item => item.path === location.pathname);
        if (menu) {
            selectedKeys.push(menu.key);
        }
        return (
            <Menu
                selectedKeys={selectedKeys}
                mode="horizontal"
            >
                {
                    menus.map(item => (
                        <Item key={item.key}>
                            <Link to={item.path}>
                                {item.display}
                            </Link>
                        </Item>
                    ))
                }
            </Menu>
        );
    }
}

module.exports = withRouter(Sidebar);