import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Row, Col, Select, Button, Table, message, Dialog, Input, Checkbox } from 'td-ui';
import Shuttle from '../components/shuttle';

const Option = Select.Option;
const Column = Table.Column;

@inject('overviewStore', 'userStore', 'groupStore', 'policyStore', 'appStore')
@observer
export default class GroupManager extends Component {
  render() {
    const { overviewStore, userStore, groupStore, appStore } = this.props;
    const { appId } = overviewStore;
    const appList = overviewStore.list;
    const userList = userStore.list;
    const groupList = groupStore.list;
    const { showAddDialog, showEditDialog, showAuthDialog, editingGroup, editingGroupUsers, dataSource } = groupStore;
    
    return (
      <div className="account-content account-groupmanager">
        <div >
          <Row className="account-content-container account-groupmanager-block">
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
                groupStore.setShowAddDialog(true);
              }}>创建群组</Button>
            </Col>
          </Row>
          <Row style={{ height: 15 }}/>
          <Row className="account-content-container account-groupmanager-block">
            <Col style={{ padding: 20 }}>
              <Table
                pagination={false}
                dataSource={groupList.toJS()}
                rowKey="groupId"
                >
                <Column key="groupId" dataIndex="groupId" title="组ID"/>
                <Column key="name" dataIndex="name" title="群组名"/>
                <Column key="description" dataIndex="" title="描述"/>
                <Column key="created" dataIndex="created" title="创建时间"/>
                <Column key="modified" dataIndex="modified" title="更新时间"/>
                <Column title="操作" dataIndex="operation" key="operation" render={(text, record) => (
                  <ul className="account-groupmanager-operation">
                    <li><Button type="primary" onClick={() => {
                      groupStore.setEditingGroupId(record.groupId);
                      groupStore.searchEditingGroupPolicys().then(() => {
                        groupStore.setShowAuthDialog(true);
                      });
                    }}>授权</Button></li>
                    <li><Button type="primary" onClick={() => {
                      groupStore.setEditingGroupId(record.groupId);
                      groupStore.searchEditingGroupUsers().then(() => {
                        groupStore.setShowEditDialog(true);
                      });
                    }}>编辑组成员</Button></li>
                    <li><Button type="primary" onClick={() => groupStore.deleteGroup(appId, record.groupId)}>删除</Button></li>
                  </ul>
                )}/>
              </Table>
            </Col>
          </Row>
        </div>
        <Dialog
          className="account-usermanager-dialog"
          title="创建群组"
          okText="创建"
          onCancel={() => groupStore.setShowAddDialog(false)}
          onOk={() => groupStore.addGroup(appId)}
          visible={showAddDialog}
          >
          <Row>
            <Row>
              <Col span={3} offset={3}>应用ID</Col>
              <Col span={10}>{appId}</Col>
            </Row>
            <Row>
              <Col span={3} offset={3}>群组名</Col>
              <Col span={10}>
                <Input 
                  defaultValue={groupStore._name} 
                  onChange={e => groupStore._name = e.target.value}
                />
              </Col>
            </Row>
            <Row>
              <Col span={3} offset={3}>描述</Col>
              <Col span={10}>
                <Input 
                  defaultValue={groupStore._description} 
                  onChange={e => groupStore._description = e.target.value}
                />
              </Col>
            </Row>
          </Row>
        </Dialog>
        <Dialog
          className="account-usermanager-dialog"
          title={editingGroup.name}
          footer={<Button onClick={() => groupStore.setShowEditDialog(false)}>关闭</Button>}
          visible={showEditDialog}
          >
          <Row>
            {
              userList.map(user => (
                <Row key={user.userId}>
                  <Col span={3} offset={3} style={{ fontSize: 16 }}>{user.realname}</Col>
                  <Col span={3} offset={12}>
                    <Checkbox checked={!!editingGroupUsers.find(item => item.userId == user.userId)} onChange={e => {
                      if (e.target.checked) {
                        groupStore.addUserToGroup(user.userId);
                      } else {
                        groupStore.removeUserFromGroup(user.userId);
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
          title={editingGroup.name}
          footer={<Button onClick={() => groupStore.setShowAuthDialog(false)}>关闭</Button>}
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
            onSelect={record => groupStore.addGroupPolicy(record.name)}
            onUnselect={record => groupStore.removeGroupPolicy(record.name)}
            onSourceSearch={key => groupStore.filterSource(key)}
            onTargetSearch={key => groupStore.filterTarget(key)}
          />
        </Dialog>
      </div>
    );
  }
}