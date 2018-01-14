import {observable, action, computed, autorun} from 'mobx';

export default class Store {
    @observable rentalStore;

    @observable driverName;
    @observable currentPage = 1;

    @observable selectedDriver;
    @observable showRecordPanel;
    @observable recordList = [];
    @observable recordPage = {};

    constructor(rentalStore) {
        this.rentalStore = rentalStore;

        autorun(() => {
            if (this.selectedDriver) {
                this.refreshRecordList(1);
            }
        })
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @computed
    get driverList() {
        const driverList = this.rentalStore.driverList;
        return this.driverName ? driverList.filter(item => {
            return item.name.toLowerCase().indexOf(this.driverName.toLowerCase()) >= 0
        }) : driverList;
    }

    @action
    setDriverName(driverName) {
        this.driverName = driverName;
    }

    @action
    setSelectedDriver(driverName) {
        this.selectedDriver = driverName;
    }

    @action
    setShowRecordPanel(status) {
        this.showRecordPanel = status;
    }

    @action setCurrentPage(page) {
        this.currentPage = page;
    }

    @action
    async removeRecord(id) {
        const result = await fetch(`/driver/remove`, {
            credentials: 'include',
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
            },
            body: this.urlencoded({id : id})
        }).then(res => res.json());
        if (result.status === 0) {
            this.refreshRecordList(1)
        }
        return result;
    }

    @action
    async refreshRecordList(page) {
        const result = await fetch(`/driver/record?driver=${this.selectedDriver}&page=${page}`, {
            credentials: 'include',
        }).then(res => res.json());
        if (result.status === 0) {
            this.recordList = result.data.list || [];
            this.recordPage = result.data.pager || {}
        }
    }
}