import {observable, action} from 'mobx';

export default class Store {
    @observable list = [];
    @observable pager = {};

    @observable searchNumber;
    @observable searchName;

    @observable showProductAddPanel = false;
    @observable showSalesPanel = false;

    @observable selectedProduct = {};

    currentPage = 1;

    constructor() {
        // this.searchProducts(this.searchNumber, this.searchName, 1)
    }

    urlencoded(data) {
        return Object.keys(data)
            .filter(key => data[key] !== undefined && data[key] !== null)
            .map(key => `${key}=${encodeURIComponent(data[key])}`).join('&')
    }

    @action
    async searchProducts(number, name, page) {
        this.currentPage = page;
        const res = await fetch(`/product/store?number=${number || ''}&name=${name || ''}&page=${page}`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.list = res.data.list || [];
            this.pager = res.data.pager || {}
        }
    }

    @action
    async deleteProduct(productId) {
        const res = await fetch(`/product/delete?id=${productId}`, {
            credentials: 'include'
        }).then(res => res.json());
        if (res.status === 0) {
            this.searchProducts(this.searchNumber, this.searchName, this.currentPage)
        }
        return res;
    }

    @action
    async createProduct(data) {
        const res = await fetch('/product/add', {
            method: 'post',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
            },
            body: this.urlencoded(data)
        }).then(res => res.json());
        if (res.status === 0) {
            this.searchProducts(this.searchNumber, this.searchName, this.currentPage)
        }
        return res;
    }

    @action
    async salesProduct(data) {
        return await fetch('/product/sales', {
            method: 'post',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
            },
            body: this.urlencoded(data)
        }).then(res => res.json());
    }

    @action
    setSearchNumber(number) {
        this.searchNumber = number;
    }

    @action
    setSearchName(name) {
        this.searchName = name
    }

    @action
    setShowProductAddPanel(status) {
        this.showProductAddPanel = status;
    }

    @action
    setShowSalesPanel(status) {
        this.showSalesPanel = status
    }

    @action
    setSelectedProduct(product) {
        this.selectedProduct = product
    }
}