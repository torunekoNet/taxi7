import {observable, action, computed, autorun} from 'mobx';

export default class Store {
    @observable driverList = [];
    @observable vehicleList = [];

    @observable driverName;
    @observable license;
    @observable type;

    constructor() {
        this.refreshDriverList();
        this.refreshVehicleList();
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @computed
    get driver() {
        return this.driverList.find(item => item.name === this.driverName) || {};
    }

    @computed
    get vehicle() {
        return this.vehicleList.find(item => item.license === this.license) || {};
    }

    @action
    async create(data) {
        const result = await fetch(`/driver/add`, {
            credentials: 'include',
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
            },
            body: this.urlencoded(data)
        }).then(res => res.json());
        if (result.status === 0) {
            this.refreshDriverList();
            this.refreshVehicleList();
        }
        return result;
    }

    @action
    async refreshDriverList() {
        const res = await fetch(`/driver/driver`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.driverList = res.data.list || [];
        }
    }

    @action
    async refreshVehicleList() {
        const res = await fetch(`/driver/vehicle`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.vehicleList = res.data.list || [];
        }
    }

    @action
    setDriverName(name) {
        this.driverName = name;
    }

    @action
    setLicense(license) {
        this.license = license;
    }

    @action
    setType(type) {
        this.type = type;
    }
}