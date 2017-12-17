import React, {Component} from 'react';
import {withRouter, Link} from "react-router-dom";
import {Menu} from 'td-ui';
import Icon from './tdcicon';

const ItemGroup = Menu.ItemGroup;
const Item = Menu.Item;
const menus = [{
    key: 'gateway',
    display: '汽车配件',
    items: [{
        key: 'gateway',
        display: '配件管理',
        path: '/product'
    }, {
        key: 'data',
        display: '流水数据',
        path: '/assembly'
    }]
}];

class Sidebar extends Component {
    render() {
        const {location} = this.props;
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
                                            <Icon type={item.icon}
                                                  style={{float: 'left', marginRight: 10, fontSize: 20}}/>
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