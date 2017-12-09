import React from 'react';
import { observable, action } from 'mobx';
import JSONFormat from 'json-format';
import { Dialog } from 'td-ui';
const domain = window.proxy || '';

export default class Store {
  @observable list = [];
  @observable type = 'sys';
  
  constructor() {
    fetch(`${domain}/v1/api/security/role`, {
      credentials: 'include'
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          this.list = data.list || [];
        }
      });
  }
  
  @action setList(list) {
    this.list = list || [];
  }
  
  @action setRoleType(type) {
    this.type = type || 'sys';
  }
  
  @action showPolicy(name) {
    fetch(`${domain}/v1/api/security/role/${name}`, {
      credentials: 'include'
    })
      .then(res => res.json())
      .then(res => {
        let policy = {};
        if (res.success) {
          policy = res.data.permission;
          
        }
        Dialog.success({
          title: <span style={{
            color: 'rgba(0, 0, 0, 0.65)',
            fontWeight: 700,
            fontSize: 20
          }}>{name}</span>,
          okText: '关闭',
          width: 600,
          icon: false,
          content: (
            <div className="account-policy-code">
              <pre>
                <code>
                  {JSONFormat(policy, { type: 'space', size: 4 })}
                </code>
              </pre>
            </div>
          )
        })
      });
  }
}