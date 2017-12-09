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
  @observable editingGroupId = '';
  @observable editingGroupUsers = [];
  @observable editingGroupPolicys = [];
  @observable sourceFilterKey = '';
  @observable targetFilterKey = '';
  
  constructor(policyStore) {
    this.policyStore = policyStore;
  }
  
  @computed get dataSource() {
    const target = this.editingGroupPolicys.filter(policy => {
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
  
  @computed get editingGroup() {
    return this.list.find(group => group.groupId == this.editingGroupId) || {};
  }
  
  @action setShowEditDialog(showEditDialog) {
    this.showEditDialog = showEditDialog;
  }
  
  @action setShowAuthDialog(showAuthDialog) {
    this.showAuthDialog = showAuthDialog;
  }
  
  @action setEditingGroupId(editingGroupId) {
    this.editingGroupId = editingGroupId;
  }
  
  @action setList(list) {
    this.list = list || [];
  }
  
  @action async searchEditingGroupUsers() {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/user`, {
        credentials: 'include'
      })
      .then(res => res.json());
      if (data.success) {
        this.editingGroupUsers = data.list || [];
      }
    }
  }
  
  @action async searchEditingGroupPolicys() {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/role`, {
        credentials: 'include'
      })
      .then(res => res.json());
      if (data.success) {
        this.editingGroupPolicys = data.list || [];
      }
    }
  }
  
  @action searchGroups(appId) {
    fetch(`${domain}/v1/api/security/group?appId=${appId}`, {
      credentials: 'include'
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.setList(data.list);
        }
      });
  }
  
  @action async addGroup(appId) {
    if (!this._name) {
      message.warning('群组名不能为空');
      return false;
    }
    const data = await fetch(`${domain}/v1/api/security/group`, {
      method: 'post',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
      },
      body: `appId=${appId || ''}&name=${this._name || ''}&description=${this._description || ''}`
    })
    .then(res => res.json());
    if (data.success) {
      message.success('添加成功');
      await this.searchGroups(appId);
    } else {
      message.warning(data.message);
    }
    this.showAddDialog = false;
  }
  
  @action setShowAddDialog(showAddDialog) {
    this.showAddDialog = showAddDialog;
  }
  
  @action async deleteGroup(appId, groupId) {
    const data = await fetch(`${domain}/v1/api/security/group/${groupId}`, {
      credentials: 'include',
      method: 'delete'
    })
    .then(res => res.json());
    if (data.success) {
      message.success('删除成功');
      await this.searchGroups(appId);
    } else {
      message.warning(data.message);
    }
  }
  
  @action async addUserToGroup(userId) {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/user/${userId}`, {
        credentials: 'include',
        method: 'post'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingGroupUsers();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async removeUserFromGroup(userId) {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/user/${userId}`, {
        credentials: 'include',
        method: 'delete'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingGroupUsers();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async addGroupPolicy(policyName) {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/role/${policyName}`, {
        credentials: 'include',
        method: 'post'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingGroupPolicys();
      } else {
        message.warning(data.message);
      }
    }
  }
  
  @action async removeGroupPolicy(policyName) {
    if (this.editingGroupId) {
      const data = await fetch(`${domain}/v1/api/security/group/${this.editingGroupId}/role/${policyName}`, {
        credentials: 'include',
        method: 'delete'
      })
      .then(res => res.json());
      if (data.success) {
        message.success(data.message);
        await this.searchEditingGroupPolicys();
      } else {
        message.warning(data.message);
      }
    }
  }
}