import React from 'react';
import { observable, action, computed } from 'mobx';
import { message } from 'td-ui';
import _ from 'lodash';

const domain = window.proxy || '';

export default class Store {
  @observable list = [];
  @observable showAddDialog = false;
  @observable showEditDialog = false;
  @observable showAuthDialog = false;
  @observable editingUserId = '';
  @observable editingUserGroups = [];
  @observable editingUserPolicys = [];
  @observable sourceFilterKey = '';
  @observable targetFilterKey = '';
  
  constructor(policyStore) {
    this.policyStore = policyStore;
  }
  
  @computed get editingUser() {
    return this.list.find(user => user.userId == this.editingUserId) || {};
  }
  
  @computed get dataSource() {
    const target = this.editingUserPolicys.filter(policy => {
      if (!this.targetFilterKey) {
        return true;
      }
      return policy.name.indexOf(this.targetFilterKey) != -1 || policy.description.indexOf(this.targetFilterKey) != -1
    });
    const source = _.difference(this.policyStore.list, target).filter(policy => {
      if (!this.sourceFilterKey) {
        return true;
      }
      return policy.name.indexOf(this.sourceFilterKey) != -1 || policy.description.indexOf(this.sourceFilterKey) != -1
    });
    return {
      source,
      target
    };
  }
  
  @action filterSource(key) {
    this.sourceFilterKey = key;
  }
  
  @action filterTarget(key) {
    this.targetFilterKey = key;
  }
  
  @action setShowEditDialog(showEditDialog) {
    this.showEditDialog = showEditDialog;
  }
  
  @action setShowAuthDialog(showAuthDialog) {
    this.showAuthDialog = showAuthDialog;
  }
  
  @action setEditingUserId(editingUserId) {
    this.editingUserId = editingUserId;
  }
  
  @action async searchEditingUserPolicys() {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/user/${this.editingUserId}/role`, {
        credentials: 'include'
      })
      .then(res => res.json());
      if (data.success) {
        this.editingUserPolicys = data.list || [];
      }
    }
  }
  
  @action async searchEditingUserGroups() {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/user/${this.editingUserId}/group`, {
        credentials: 'include'
      })
      .then(res => res.json());
      if (data.success) {
        this.editingUserGroups = data.list || [];
      }
    }
  }
  
  @action setList(list) {
    this.list = list || [];
  }
  
  @action searchUsers(appId) {
    return fetch(`${domain}/v1/api/security/user?appId=${appId}`, {
      credentials: 'include'
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.setList(data.list);
        }
      });
  }
  
  @action async addUser(appId) {
    if (!this._userName) {
      message.warning('AD账号不能为空');
      return false;
    }
    if (!this._realName) {
      message.warning('姓名不能为空');
      return false;
    }
    const formData = new FormData();
    formData.append('appId', appId);
    formData.append('username', this._userName);
    formData.append('realname', this._realName);
    const data = await fetch(`${domain}/v1/api/security/user`, {
      method: 'post',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
      },
      body: `appId=${appId}&username=${this._userName || ''}&realname=${this._realName || ''}`
    })
    .then(res => res.json());
    if (data.success) {
      message.success('添加成功');
      await this.searchUsers(appId);
    } else {
      message.warning(data.message);
    }
    this.showAddDialog = false;
  }
  
  @action setShowAddDialog(showAddDialog) {
    this.showAddDialog = showAddDialog;
  }
  
  @action async deleteUser(appId, userId) {
    const data = await fetch(`${domain}/v1/api/security/user/${userId}`, {
      credentials: 'include',
      method: 'delete'
    })
    .then(res => res.json());
    if (data.success) {
      message.success('删除成功');
      await this.searchUsers(appId);
    } else {
      message.warning(data.message);
    }
  }
  
  @action async addUserToGroup(groupId) {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/group/${groupId}/user/${this.editingUserId}`, {
        credentials: 'include',
        method: 'post'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingUserGroups();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async removeUserFromGroup(groupId) {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/group/${groupId}/user/${this.editingUserId}`, {
        credentials: 'include',
        method: 'delete'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingUserGroups();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async addUserPolicy(policyName) {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/user/${this.editingUserId}/role/${policyName}`, {
        credentials: 'include',
        method: 'post'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingUserPolicys();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async removeUserPolicy(policyName) {
    if (this.editingUserId) {
      const data = await fetch(`${domain}/v1/api/security/user/${this.editingUserId}/role/${policyName}`, {
        credentials: 'include',
        method: 'delete'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingUserPolicys();
      } else {
        message.warning(data.message);
      }
    }
  }
}