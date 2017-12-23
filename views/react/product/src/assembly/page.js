import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import moment from 'moment';
import {Button, Input, Row, Col, Message, Pagination, Collapse} from 'td-ui';

const Panel = Collapse.Panel;

@inject('assemblyStore')
@observer
export default class Assembly extends Component {

    render() {
        const {assemblyStore} = this.props;
        const {list, pager, to, comment} = assemblyStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={16}>
                            <Input value={to} addonBefore="去向"
                                   onChange={e => assemblyStore.setTo(e.target.value)
                                   }/>
                        </Col>
                        <Col offset={2} span={3}>
                            <Button onClick={() => assemblyStore.searchAssembly(to, comment, 1)}>搜索</Button>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={16}>
                            <Input value={comment} addonBefore="备注"
                                   onChange={e => assemblyStore.setComment(e.target.value)
                                   }/>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Collapse activeKey={list.map(i => i.id)}>
                                {
                                    list.map(i => {
                                        const time = moment(parseInt(i.gmt_create) * 1000).format('YYYY-MM-DD HH:mm:ss')
                                        return (
                                            <Panel
                                                header={[
                                                    <span key="title">{i.cargo_name}</span>,
                                                    <Row key="content">
                                                        <Col span={6}>
                                                            去向:{i.to}
                                                        </Col>
                                                        <Col span={4}>
                                                            数量:{i.amount}
                                                        </Col>
                                                        <Col span={14}>
                                                            时间:{time}
                                                        </Col>
                                                    </Row>
                                                ]}
                                                key={i.id}>
                                                <p>{i.comment}</p>
                                            </Panel>
                                        )
                                    })
                                }
                            </Collapse>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col>
                            <Pagination
                                current={pager.currentPage + 1}
                                total={pager.itemCount}
                                pageSize={pager.pageSize}
                                onChange={(page) => assemblyStore.searchAssembly(to, comment, page)}
                            />
                        </Col>
                    </Row>
                </div>
            </div>
        )
    }
}