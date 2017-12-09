import React, { Component } from 'react';
import { observer, inject } from 'mobx-react';
import { Select, Row, Col } from 'td-ui';

const Option = Select.Option;
const demo = `
策略定义：
{
    "version": 1,                   // 版本号
    "statements": [
        {
            "domain": "shutter",    // PaaS上的某一项服务，如Shutter、Cache
            "actions": [            // 某一项服务中的一些动作，动作由服务提供者提供
                "GetConfig",
                "GetConfigList",
                "GetConfigHistoryList",
                "GetConfigPollingList"
            ],
            "targets": []           // 动作操作的对象
        }
    ]
}

例如：定义一个策略，拥有Shutter中forseti.properties的查看（Read）和修改（Update）权限：
{
    "version": 1,                   // 版本号
    "statements": [
        {
            "domain": "shutter",    // PaaS上的某一项服务，如Shutter、Cache
            "actions": [            // 某一项服务中的一些动作，动作由服务提供者提供
                "GetConfig",
                "GetConfigList",
                "GetConfigHistoryList",
                "UpdateConfig",
                "RollbackConfig"
            ],
            "targets": [            // 动作操作的对象
                "forseti.properties"
            ]
        }
    ]
}
此策略可以查看配置文件列表、查看和修改forseti.properteis文件内容，查看forseti.properteis的历史修改记录。
`;

@inject('overviewStore', 'userStore', 'groupStore', 'policyStore', 'appStore')
@observer
export default class Overview extends Component {
  render() {
    const { overviewStore, userStore, groupStore, appStore } = this.props;
    const { appId } = overviewStore;
    const appList = overviewStore.list;
    const userList = userStore.list;
    const groupList = groupStore.list;
    
    return (
      <div className="account-content account-overview">
        <div >
          <Row className="account-content-container account-overview-block">
            <Col span={2} style={{
              lineHeight: '32px'
            }}>
              应用
            </Col>
            <Col>
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
          </Row>
          <Row style={{ height: 15 }}/>
          <Row className="account-content-container account-overview-block">
            <Col span={7} style={{ paddingLeft: 10, borderBottom: '1px solid rgba(0,0,0,.1)' }}>
              <div className="account-overview-title">用户概览</div>
              <div className="account-overview-count">您有（{userList.length}）个用户</div>
            </Col>
            <Col span={1} />
            <Col span={7} style={{ paddingLeft: 10, borderBottom: '1px solid rgba(0,0,0,.1)' }}>
              <div className="account-overview-title">群组概览</div>
              <div className="account-overview-count">您有（{groupList.length}）个群组</div>
            </Col>
            <Col span={1} />
            <Col span={7} style={{ paddingLeft: 10, borderBottom: '1px solid rgba(0,0,0,.1)' }}>
              <div className="account-overview-title">授权策略概览</div>
              <div className="account-overview-count">您有（0）个自定义授权策略</div>
            </Col>
            <Col span={1} />
          </Row>
          <Row className="account-content-container account-overview-block">
            <Col style={{ paddingLeft: 10 }}>
              <div className="account-overview-title">操作引导</div>
              <ul className="account-overview-count">
                <li>1. 管理授权策略</li>
                <li>2. 创建群组并授权</li>
                <li>3. 创建用户并加入群组</li>
                <li>4. 完成授权</li>
              </ul>
            </Col>
          </Row>
          <Row className="account-content-container account-overview-block">
            <Col style={{ paddingLeft: 10 }}>
              <div className="account-overview-title">自定义策略指南</div>
              <div className="account-overview-code">
                <pre>
                  <code dangerouslySetInnerHTML={{ __html: demo }} />
                </pre>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    );
  }
}