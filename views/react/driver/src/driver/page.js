import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import {Button, Input, Row, Col, Message, Pagination, Collapse, Table} from 'td-ui';

const Panel = Collapse.Panel;
const Column = Table.Column;

@inject('driverStore')
@observer
export default class Driver extends Component {

    renderRecord() {
        const {driverStore} = this.props;
        const {recordList, recordPage, selectedDriver} = driverStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col>
                            <Button onClick={() => {
                                driverStore.setSelectedDriver(undefined);
                                driverStore.setShowRecordPanel(false);
                            }}>&lt; {selectedDriver}</Button>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col>
                            <Table
                                dataSource={recordList.toJS()}
                                pagination={{
                                    current: recordPage.currentPage + 1,
                                    total: recordPage.itemCount,
                                    pageSize: recordPage.pageSize,
                                    onChange: (page) => driverStore.refreshRecordList(page)
                                }}
                            >
                                <Column width='25%' title="车牌" key="license" dataIndex="license"/>
                                <Column width='30%' title="时间" key="time" dataIndex="time" render={(value, record) => {
                                    return (<div><p>{record.begin_time}</p><p>{record.end_time}</p></div>)
                                }}/>
                                <Column width='15%' title="租金" key="rent" dataIndex="rent" render={(value, record) => {
                                    return record.end_time ? value / 100 : ''
                                }}/>
                                <Column title="备注" key="comment" dataIndex="comment"/>
                            </Table>
                        </Col>
                    </Row>
                </div>
            </div>
        );
    }

    renderDriver() {
        const {driverStore} = this.props;
        const {driverName, driverList} = driverStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={16}>
                            <Input value={driverName}
                                   onChange={e => driverStore.setDriverName(e.target.value)}
                                   addonBefore="驾驶员"/>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Collapse defaultActiveKey={driverList.map(d => d.name)}>
                                {
                                    driverList.map(driver => (
                                        <Panel key={driver.name} header={`${driver.name}（${driver.identity}）`}>
                                            <Row>
                                                <Col>手机号码：<a href={`tel:${driver.phone}`}>{driver.phone}</a></Col>
                                                <Col>
                                                    <Button
                                                        onClick={() => {
                                                            driverStore.setSelectedDriver(driver.name);
                                                            driverStore.setShowRecordPanel(true);
                                                        }}>租车明细</Button>
                                                </Col>
                                            </Row>
                                        </Panel>
                                    ))
                                }
                            </Collapse>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col>
                            <Pagination
                                current={1}
                                total={driverList.length}
                                pageSize={5}
                                onChange={page => console.log(page)}
                            />
                        </Col>
                    </Row>
                </div>
            </div>
        )
    }

    render() {
        const {driverStore} = this.props;
        const {showRecordPanel} = driverStore;

        return showRecordPanel ? this.renderRecord() : this.renderDriver();
    }
}