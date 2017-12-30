import {observable, action, computed, autorun} from 'mobx';

export default class Store {
    @observable driverList = [];
    @observable vehicleList = [];

    @observable driverName;

    constructor() {
        this.refreshDriverList();
        this.refreshVehicleList();

        autorun(() => {
            if (this.driverName) {
                this.refreshDriverList();
            }
        })
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @computed
    get driver() {
        return this.driverList.find(item => item.driver === this.driverName) || {};
    }

    @action
    async refreshDriverList() {
        const res = await fetch(`/driver/driver`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.driverList = res.data.list;
        }
    }

    @action
    async refreshVehicleList() {
        const res = await fetch(`/driver/vehicle`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.vehicleList = res.data.list;
        }
    }

    @action
    setDriverName(name) {
        this.driverName = name;
    }
}