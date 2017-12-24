import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import {Input, Row, Col, Message, Form, Button, Radio, Dialog, Collapse, Pagination} from 'td-ui';

const Textarea = Input.Textarea;
const Panel = Collapse.Panel;

@Form.create()
@inject('rentalStore')
@observer
export default class Rental extends Component {

    render() {
        const {rentalStore} = this.props;
        const {driver} = rentalStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={16}>
                            <Input addonBefore="汽车号牌"/>
                        </Col>
                        <Col offset={2} span={3}>
                            <Button>搜索</Button>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Collapse defaultActiveKey={["浙CA2304"]}>
                                <Panel key="浙CA2304" header="浙CA2304（白:在租,夜:空闲）">
                                    <Row>
                                        <Col>班次：白班</Col>
                                        <Col>驾驶员：张三（330304YYYYMMDD1234）</Col>
                                        <Col>手机号码：<a href="tel:13003691217">136XXXX1102</a></Col>
                                        <Col>时间：2017-12-24 至 2018-01-03</Col>
                                        <Col>租金：500元 / 10天</Col>
                                        <Col>
                                            <Button onClick={() => {
                                                Dialog.confirm({
                                                    title: '浙CA2304 信息确认',
                                                    content: (
                                                        <Row>
                                                            <Col>
                                                                预计结束：2018-01-03
                                                            </Col>
                                                            <Col>
                                                                实际结束：2017-12-31
                                                            </Col>
                                                            <br/>
                                                            <Col>
                                                                <Input addonBefore="实际租金"/>
                                                            </Col>
                                                            <br/>
                                                            <Col>
                                                                <Textarea placeholder="备注"/>
                                                            </Col>
                                                        </Row>
                                                    ),
                                                    width: 300,
                                                    onOk: () => {
                                                    }
                                                })
                                            }}>收租金</Button>
                                        </Col>
                                    </Row>
                                    <Row style={{height: 15}}/>
                                    <Row>
                                        <Col>班次：夜班</Col>
                                        <Col>驾驶员：李四（330304YYYYMMDD1234）</Col>
                                        <Col>手机号码：<a href="tel:13003691217">136XXXX1102</a></Col>
                                        <Col>时间：2017-12-24 至 2018-01-03</Col>
                                        <Col>租金：500元 / 10天</Col>
                                        <Col>
                                            <Button onClick={() => {
                                                Dialog.confirm({
                                                    title: '浙CA2304 信息确认',
                                                    content: (
                                                        <Row>
                                                            <Col>
                                                                预计结束：2018-01-03
                                                            </Col>
                                                            <Col>
                                                                实际结束：2017-12-31
                                                            </Col>
                                                            <br/>
                                                            <Col>
                                                                <Input addonBefore="实际租金"/>
                                                            </Col>
                                                            <br/>
                                                            <Col>
                                                                <Textarea placeholder="备注"/>
                                                            </Col>
                                                        </Row>
                                                    ),
                                                    width: 300,
                                                    onOk: () => {
                                                    }
                                                })
                                            }}>收租金</Button>
                                        </Col>
                                    </Row>
                                </Panel>
                                <Panel key="浙CB2304" header="浙CB2304（空闲）">
                                    <Button><Link to="/">去租车</Link></Button>
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
                                pageSize={20}
                                onChange={page => console.log(page)}
                            />
                        </Col>
                    </Row>
                </div>
            </div>
        )
    }
}