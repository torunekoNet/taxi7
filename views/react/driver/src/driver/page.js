import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import {Button, Input, Row, Col, Message, Pagination, Collapse, Table, Dialog} from 'td-ui';

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
                                scroll={{x: '150%'}}
                                rowKey="id"
                            >
                                <Column width={80} title="车牌" key="license" dataIndex="license" fixed="left"/>
                                <Column width={100} title="时间" key="time" dataIndex="time" render={(value, record) => {
                                    return (<div><p>{record.begin_time}</p><p>{record.end_time}</p></div>)
                                }}/>
                                <Column width={60} title="班次" key="type" dataIndex="type" render={value => {
                                    return parseInt(value) === 0 ? "白班" : parseInt(value) === 1 ? "夜班" : "全天";
                                }}/>
                                <Column width={80} title="租金" key="rent" dataIndex="rent" render={(value, record) => {
                                    return record.end_time ? value / 100 : ''
                                }}/>
                                <Column title="备注" key="comment" dataIndex="comment"/>
                                <Column title="删除" key="remove" width={80} render={(value, record) => (
                                    <Button type="primary" onClick={() => {
                                        Dialog.confirm({
                                            title: "删除确认",
                                            content: (
                                                <Row>
                                                    <Col>
                                                        出租车: {record.license}
                                                    </Col>
                                                    <Col>
                                                        驾驶员: {selectedDriver}
                                                    </Col>
                                                    <Col>
                                                        开始时间: {record.begin_time}
                                                    </Col>
                                                    <Col>
                                                        预计到期: {record.end_time}
                                                    </Col>
                                                    <Col>
                                                        班次：{parseInt(record.type) === 0 ? "白班" : parseInt(record.type) === 1 ? "夜班" : "全天"}
                                                    </Col>
                                                    <Col>
                                                        租金: {record.rent / 100} 元
                                                    </Col>
                                                </Row>
                                            ),
                                            width: 300,
                                            onOk: () => {
                                                driverStore.removeRecord(record.id).then(result => {
                                                    if (result.status === 0) {
                                                        Message.success(result.info);
                                                    } else {
                                                        Message.warning(result.info);
                                                    }
                                                })
                                            }
                                        })
                                    }}>删除</Button>
                                )}/>
                            </Table>
                        </Col>
                    </Row>
                </div>
            </div>
        );
    }

    renderDriver() {
        const {driverStore} = this.props;
        const {driverName, driverList, currentPage} = driverStore;
        const pageSize = 10;

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
                                    driverList.slice((currentPage - 1) * pageSize, currentPage * pageSize).map(driver => (
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
                                current={currentPage}
                                total={driverList.length}
                                pageSize={pageSize}
                                onChange={page => driverStore.setCurrentPage(page)}
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