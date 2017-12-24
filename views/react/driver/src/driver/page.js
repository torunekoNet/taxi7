import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import {Button, Input, Row, Col, Message, Pagination, Collapse, Table} from 'td-ui';

const Panel = Collapse.Panel;
const Column = Table.Column;

@inject('driverStore')
@observer
export default class Driver extends Component {

    render() {
        const {driverStore} = this.props;
        const {list, pager, to, comment} = driverStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={16}>
                            <Input addonBefore="驾驶员"/>
                        </Col>
                        <Col offset={2} span={3}>
                            <Button>搜索</Button>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Collapse defaultActiveKey={["张三"]}>
                                <Panel key="张三" header="张三（330304YYYYMMDD1234）">
                                    <Row>
                                        <Col>手机号码：<a href="tel:13003691217">136XXXX1102</a></Col>
                                        <Col>
                                            <Table dataSource={[{
                                                license: "浙CA2304",
                                                beginTime: "2017-12-20",
                                                endTime: "2017-12-24",
                                                type: '夜班',
                                                rent: 200
                                            }]}
                                                   rowKey="license">
                                                <Column title="汽车号牌" dataIndex="license" key="license"/>
                                                <Column title="时间" key="time" render={(value, record) => (
                                                    <ul>
                                                        <li key="1">{record.beginTime}</li>
                                                        <li key="2">{record.endTime}</li>
                                                    </ul>
                                                )}/>
                                                <Column title="班次" key="type" dataIndex="type"/>
                                                <Column title="租金" dataIndex="rent" key="rent"
                                                        render={(value, record) => {
                                                            if (value) {
                                                                return (<span>{value}</span>)
                                                            } else {
                                                                return (
                                                                    <Button><Link
                                                                        to="/rental/vehicle">收租金</Link></Button>
                                                                )
                                                            }
                                                        }}/>
                                            </Table>
                                        </Col>
                                    </Row>
                                </Panel>
                                <Panel key="李四" header="李四（330304YYYYMMDD4321）">
                                    <Col>手机号码：<a href="tel:13003691217">136XXXX1102</a></Col>
                                    <Col>
                                        <Table dataSource={[{
                                            license: "浙CA2304",
                                            beginTime: "2017-12-24",
                                            endTime: "2017-01-03",
                                            type: '白班',
                                            rent: null
                                        }]}
                                               rowKey="license">
                                            <Column title="汽车号牌" dataIndex="license" key="license"/>
                                            <Column title="时间" key="time" render={(value, record) => (
                                                <ul>
                                                    <li key="1">{record.beginTime}</li>
                                                    <li key="2">{record.endTime}</li>
                                                </ul>
                                            )}/>
                                            <Column title="班次" key="type" dataIndex="type"/>
                                            <Column title="租金" dataIndex="rent" key="rent" render={(value, record) => {
                                                if (value) {
                                                    return (<span>{value}</span>)
                                                } else {
                                                    return (
                                                        <Button size="small"><Link to="/rental/vehicle">收租金</Link></Button>
                                                    )
                                                }
                                            }}/>
                                        </Table>
                                    </Col>
                                </Panel>
                            </Collapse>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col>
                            <Pagination
                                current={1}
                                total={10}
                                pageSize={5}
                                onChange={page => console.log(page)}
                            />
                        </Col>
                    </Row>
                </div>
            </div>
        )
    }
}