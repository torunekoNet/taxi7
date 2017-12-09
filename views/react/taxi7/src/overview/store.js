import { observable, action, autorun } from 'mobx';

export default class Store {
  @observable appId;
  @observable list = [];
  
  constructor(userStore, groupStore, policyStore) {
    this.userStore = userStore;
    this.groupStore = groupStore;
    this.policyStore = policyStore;
    this.userStore.overviewStore = this;
    this.groupStore.overviewStore = this;
    this.policyStore.overviewStore = this;
    this.searchAppList();
    
    autorun(() => {
      if (this.appId) {
        this.groupStore.searchGroups(this.appId);
        this.userStore.searchUsers(this.appId);
      }
    });
  }
  
  @action searchAppList() {
    fetch('/v1/api/security/app', {
      credentials: 'include'
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.list = data.list || [];
        }
      });
  }
  
  @action setAppId(appId) {
    this.appId = appId;
  }
}