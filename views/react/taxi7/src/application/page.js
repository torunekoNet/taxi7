import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Link } from 'react-router-dom';
import { Table, Button } from 'td-ui';

const Column = Table.Column;

@inject('appStore', 'overviewStore')
@observer
export default class Application extends Component {
  render() {
    const { list } = this.props.appStore;

    return (
      <div className="account-app account-content">
        <div className="account-content-container" style={{ padding: 10 }}>
          <Table
            dataSource={list.toJS()}
            pagination={false}
            rowKey="appId"
            >
            <Column title="应用ID" dataIndex="appId" key="appId"/>
            <Column title="负责人" dataIndex="manager" key="manager"/>
            <Column title="描述" dataIndex="description" key="description"/>
            <Column title="创建时间" dataIndex="created" key="created"/>
            <Column title="更新时间" dataIndex="modified" key="modified"/>
            <Column title="操作" dataIndex="operation" key="operation"
              render={(text, record) => record.administrator ? (
                <Button type="primary" onClick={() => this.props.overviewStore.setAppId(record.appId)}>
                  <Link to="/overview">管理</Link>
                </Button>
              ) : null}
            />
          </Table>
        </div>
      </div>
    );
  }
}