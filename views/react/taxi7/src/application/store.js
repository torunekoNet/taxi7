import { observable, action } from 'mobx';
const domain = window.proxy || '';

export default class Store {
  @observable list = [];
  @observable globalInfo = {};
  
  constructor() {
    window.getGlobalInfo().then(globalInfo => {
      this.globalInfo = globalInfo;
      this.list = globalInfo.apps;
    });
  }
}