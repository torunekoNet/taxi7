import {observable, action} from 'mobx';

export default class Store {
    @observable list = [];
    @observable pager = {};

    @observable to;
    @observable comment;

    constructor() {
        this.searchAssembly(this.to, this.comment, 1)
    }

    @action
    async searchAssembly(to, comment, page) {
        const res = await fetch(`/product/water?to=${to || ''}&comment=${comment || ''}&page=${page}`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.list = res.data.list || [];
            this.pager = res.data.pager || {}
        }
    }

    @action
    setTo(to) {
        this.to = to;
    }

    @action
    setComment(comment) {
        this.comment = comment;
    }
}