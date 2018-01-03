import {observable, action, computed} from 'mobx';

export default class Store {
    @observable rentalStore;

    @observable license;

    constructor(rentalStore) {
        this.rentalStore = rentalStore;
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @computed
    get vehicleList() {
        const vehicleList = this.rentalStore.vehicleList;
        return this.license ? vehicleList.filter(item => {
            return item.license.toLowerCase().indexOf(this.license.toLowerCase()) >= 0
        }) : vehicleList;
    }

    @action
    setLicense(license) {
        this.license = license;
    }

    @action
    async chargeRent(data) {
        const result = await fetch(`/driver/chargeRent`, {
            credentials: 'include',
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
            },
            body: this.urlencoded(data)
        }).then(res => res.json());
        if (result.status === 0) {
            this.rentalStore.refreshDriverList();
            this.rentalStore.refreshVehicleList();
        }
        return result;
    }
}