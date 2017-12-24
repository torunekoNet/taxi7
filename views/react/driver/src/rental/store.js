import {observable, action} from 'mobx';

export default class Store {
    @observable list = [];
    @observable pager = {};

    @observable driver = {};
    @observable driverName;


    constructor() {
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @action
    setDriverName(name) {
        this.driverName = name;
        if (this.driverName === '张三') {
            this.driver = {
                identity: '330304YYYYMMDD1234',
                phone: '136XXXX1102'
            }
        } else if (this.driverName === '李四') {
            this.driver = {
                identity: '330304YYYYMMDD4321',
                phone: '136XXXX2201'
            }
        } else {
            this.driver = {}
        }
    }
}