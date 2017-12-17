import {observable, action, computed, autorun, toJS} from 'mobx';
import React from 'react';

const domain = window.domain || '';

if (window.localStorage.refrainCollapsed === undefined) {
    window.localStorage.refrainCollapsed = 'true';
}

const menus = [{
    key: 'gateway',
    display: '汽车配件',
    target: '#/product'
}, {
    key: 'shutter',
    display: '出租车管理',
    target: '#/driver'
}];

const sleep = duration => new Promise(resolve => {
    setTimeout(resolve, duration)
});

export default class AppStore {
    @observable realname;
    username;
    @observable collapsed = window.localStorage.refrainCollapsed === 'true';
    @observable content;
    @observable selectedKey = window.localStorage.refrainMenuKey || 'taxi7';
    @observable menus = menus;

    constructor() {
        this.init();
        window.getGlobalInfo = async () => {
            while (!this._init) {
                await sleep(10);
            }
            return {
                realname: this.realname,
                username: this.username,
            };
        };
    }

    @computed get isWating() {
        const menu = this.menus.find(item => item.key === this.selectedKey);
        return !menu || !menu.target;
    }

    async init() {
        try {
            const session = await fetch(`${domain}/session`, {
                method: 'get',
                credentials: 'include'
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 0) {
                        return res.data;
                    }
                    if (res.status === -301) {
                        window.location.replace(`${domain}/login`);
                    }
                    return {};
                });
            this.username = session.username;
            this.realname = session.realname;
            this._init = true;
        } catch (e) {
            window.location.replace(`${domain}/login`);
        }
        return {
            realname: this.realname,
            username: this.username,
        };
    }

    @action setSelectedKey(selectedKey) {
        this.selectedKey = selectedKey;
        window.localStorage.refrainMenuKey = selectedKey;
        return this.menus.find(item => item.key == this.selectedKey) || {};
    }

    @action setCollapsed(collapsed) {
        this.collapsed = collapsed;
        window.localStorage.refrainCollapsed = collapsed;
    }

    @computed get selectedMenu() {
        return this.menus.find(item => item.key == this.selectedKey) || menu[0];
    }
}