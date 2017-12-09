import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Row, Col, Select, Button, Table, message, Dialog, Input, Checkbox } from 'td-ui';
import Shuttle from '../components/shuttle';

const Option = Select.Option;
const Column = Table.Column;

@inject('overviewStore', 'userStore', 'groupStore', 'policyStore', 'appStore')
@observer
export default class UserManager extends Component {
  render() {
    const { overviewStore, userStore, groupStore, appStore } = this.props;
    const { appId } = overviewStore;
    const appList = overviewStore.list;
    const userList = userStore.list;
    const groupList = groupStore.list;
    const { showAddDialog, showEditDialog, showAuthDialog, editingUser, editingUserGroups, dataSource } = userStore;
    
    return (
      <div className="account-content account-usermanager">
        <div >
          <Row className="account-content-container account-usermanager-block">
            <Col span={2} style={{
              lineHeight: '32px'
            }}>
              应用
            </Col>
            <Col span={20}>
              <Select
                placeholder='请选择' 
                style={{ width: 200 }}
                value={appId}
                showSearch
                onChange={value => overviewStore.setAppId(value)}
                >
                {
                  appList.map(app => <Option key={app.appId} value={app.appId}>{app.appId}</Option>)
                }
              </Select>
            </Col>
            <Col span={2}>
              <Button type="primary" onClick={() => {
                if (!appId) {
                  message.warning('请先选择应用');
                  return;
                }
                userStore.setShowAddDialog(true);
              }}>添加用户</Button>
            </Col>
          </Row>
          <Row style={{ height: 15 }}/>
          <Row className="account-content-container account-usermanager-block">
            <Col style={{ padding: 20 }}>
              <Table
                pagination={false}
                dataSource={userList.toJS()}
                rowKey="userId"
                >
                <Column key="userId" dataIndex="userId" title="用户ID"/>
                <Column key="username" dataIndex="username" title="用户名"/>
                <Column key="realname" dataIndex="realname" title="姓名"/>
                <Column key="created" dataIndex="created" title="创建时间"/>
                <Column key="modified" dataIndex="modified" title="更新时间"/>
                <Column title="操作" dataIndex="operation" key="operation" render={(text, record) => (
                  <ul className="account-usermanager-operation">
                    <li><Button type="primary" onClick={() => {
                      userStore.setEditingUserId(record.userId);
                      userStore.searchEditingUserPolicys().then(() => {
                        userStore.setShowAuthDialog(true);
                      });
                    }}>授权</Button></li>
                    <li><Button type="primary" onClick={() => {
                      userStore.setEditingUserId(record.userId);
                      userStore.searchEditingUserGroups().then(() => {
                        userStore.setShowEditDialog(true);
                      });
                    }}>加入组</Button></li>
                    <li><Button type="primary" onClick={() => userStore.deleteUser(appId, record.userId)}>删除</Button></li>
                  </ul>
                )}/>
              </Table>
            </Col>
          </Row>
        </div>
        <Dialog
          className="account-usermanager-dialog"
          title="添加用户"
          okText="添加"
          onCancel={() => userStore.setShowAddDialog(false)}
          onOk={() => userStore.addUser(appId)}
          visible={showAddDialog}
          >
          <Row>
            <Row>
              <Col span={3} offset={3}>应用ID</Col>
              <Col span={10}>{appId}</Col>
            </Row>
            <Row>
              <Col span={3} offset={3}>AD账号</Col>
              <Col span={10}>
                <Input 
                  defaultValue={userStore._userName} 
                  onChange={e => userStore._userName = e.target.value}
                />
              </Col>
            </Row>
            <Row>
              <Col span={3} offset={3}>姓名</Col>
              <Col span={10}>
                <Input 
                  defaultValue={userStore._realName} 
                  onChange={e => userStore._realName = e.target.value}
                />
              </Col>
            </Row>
          </Row>
        </Dialog>
        <Dialog
          className="account-usermanager-dialog"
          title={`${editingUser.realname}(${editingUser.username})`}
          footer={<Button onClick={() => userStore.setShowEditDialog(false)}>关闭</Button>}
          visible={showEditDialog}
          >
          <Row>
            {
              groupList.map(group => (
                <Row key={group.groupId}>
                  <Col span={3} offset={3} style={{ fontSize: 16 }}>{group.name}</Col>
                  <Col span={3} offset={12}>
                    <Checkbox checked={!!editingUserGroups.find(item => item.groupId == group.groupId)} onChange={e => {
                      if (e.target.checked) {
                        userStore.addUserToGroup(group.groupId);
                      } else {
                        userStore.removeUserFromGroup(group.groupId);
                      }
                    }}/>
                  </Col>
                </Row>
              ))
            }
          </Row>
        </Dialog>
        <Dialog
          className="account-usermanager-dialog"
          title={`${editingUser.realname}(${editingUser.username})`}
          footer={<Button onClick={() => userStore.setShowAuthDialog(false)}>关闭</Button>}
          visible={showAuthDialog}
          width={700}
          >
          <Shuttle 
            width={320}
            height={220}
            titles={{
              source: ['可选授权策略名称', '类型 '],
              target: ['已选授权策略名称', '类型']
            }}
            rowKey="name"
            render={record => record.name}
            dataSource={dataSource}
            onSelect={record => userStore.addUserPolicy(record.name)}
            onUnselect={record => userStore.removeUserPolicy(record.name)}
            onSourceSearch={key => userStore.filterSource(key)}
            onTargetSearch={key => userStore.filterTarget(key)}
          />
        </Dialog>
      </div>
    );
  }
}