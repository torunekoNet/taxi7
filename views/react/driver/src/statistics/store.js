import {observable, action, computed, autorun} from 'mobx';

export default class Store {
    @observable rentalStore;

    @observable recordList = [];
    @observable recordPage = {};
    @observable statistic = 0;
    @observable totalDay = 0;

    @observable license;
    @observable dirver;
    @observable begin;
    @observable end;

    constructor(rentalStore) {
        this.rentalStore = rentalStore;
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @action
    async doStatistic(license, driver, begin, end, page) {
        this.license = license ? license : this.license;
        this.driver = driver ? driver : this.driver;
        this.begin = begin ? begin : this.begin;
        this.end = end ? end : this.end;
        const result = await fetch(`/driver/statistic?page=${page || 1}&license=${license || this.license || ''}&driver=${driver || this.driver || ''}&begin_time=${begin || this.begin}&end_time=${end || this.end}`, {
            credentials: 'include',
        }).then(res => res.json());
        if (result.status === 0) {
            this.recordList = result.data.list || [];
            this.recordPage = result.data.pager || {};
            this.statistic = result.data.sum || 0;
            this.totalDay = result.data.total || 0;
        }
    }
}