import {observable, action, computed, autorun, toJS} from 'mobx';
import React from 'react';

const sleep = duration => new Promise(resolve => {
    setTimeout(resolve, duration)
});

export default class AppStore {
    @observable realname;
    @observable username;
    @observable content;

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

    async init() {
        try {
            const session = await fetch('/session', {
                method: 'get',
                credentials: 'include'
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 0) {
                        return res.data;
                    }
                    if (res.status === -301) {
                        window.location.replace('/login');
                    }
                    return {};
                });
            this.username = session.username;
            this.realname = session.realname;
            this._init = true;
        } catch (e) {
            window.location.replace('/login');
        }
        return {
            realname: this.realname,
            username: this.username,
        };
    }
}