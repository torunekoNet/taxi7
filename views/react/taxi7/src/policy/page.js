import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Row, Col, Menu, Button, Table } from 'td-ui';

const Item = Menu.Item;
const Column = Table.Column;

@inject('policyStore')
@observer
export default class Policy extends Component {
  render() {
    const { policyStore } = this.props;
    const sysRoleList = policyStore.list;
    const type = policyStore.type;
    
    return (
      <div className="account-content account-policy">
        <div >
          <Row className="account-content-container account-policy-block">
            <Col>
              <Menu
                mode="horizontal"
                selectedKeys={[type]}
                onSelect={selectedKeys => policyStore.setRoleType(selectedKeys[0])}
                >
                <Item key="sys">系统策略</Item>
                <Item key="custom">自定义策略</Item>
              </Menu>
            </Col>
          </Row>
          <Row className="account-content-container account-policy-block">
            <Col style={{ padding: 20 }}>
              {
                type == 'sys' ? (
                  <Table
                    pagination={false}
                    dataSource={sysRoleList.toJS()}
                    rowKey="name"
                    >
                    <Column key="name" dataIndex="name" title="策略名"/>
                    <Column key="description" dataIndex="description" title="描述"/>
                    <Column key="created" dataIndex="created" title="创建时间"/>
                    <Column key="modified" dataIndex="modified" title="更新时间"/>
                    <Column title="操作" dataIndex="operation" key="operation" render={(text, record) => (
                      <ul className="account-policy-operation">
                        <li><Button type="primary" onClick={() => policyStore.showPolicy(record.name)}>查看</Button></li>
                      </ul>
                    )}/>
                  </Table>
                ) : <div style={{ textAlign: 'center' }}>暂未开放</div>
              }
            </Col>
          </Row>
        </div>
      </div>
    );
  }
}