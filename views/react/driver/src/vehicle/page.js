import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import moment from 'moment';
import {Input, Row, Col, Message, Form, Button, Radio, Dialog, Collapse, Pagination, DatePicker} from 'td-ui';

const Textarea = Input.Textarea;
const Panel = Collapse.Panel;

@Form.create()
@inject('vehicleStore')
@observer
export default class Rental extends Component {

    constructor(props) {
        super(props);
        this.state = {
            rentDate: moment(),
            rent: null,
            comment: null,
        }
    }

    render() {
        const {vehicleStore} = this.props;
        const {license, vehicleList} = vehicleStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={16}>
                            <Input value={license}
                                   onChange={e => vehicleStore.setLicense(e.target.value)}
                                   addonBefore="汽车号牌"/>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Collapse defaultActiveKey={vehicleList.map(v => v.license)}>
                                {
                                    vehicleList.map(vehicle => (
                                        <Panel key={vehicle.license} header={vehicle.license}>
                                            {
                                                vehicle.day_driver ? (
                                                    <Row>
                                                        <Col>班次：白班</Col>
                                                        <Col>驾驶员：{vehicle.day_driver}（{vehicle.day_identity}）</Col>
                                                        <Col>手机号码：<a
                                                            href={`tel:${vehicle.day_phone}`}>{vehicle.day_phone}</a></Col>
                                                        <Col>时间：{vehicle.day_begin_time} 至 {vehicle.day_end_time}</Col>
                                                        <Col>租金：{vehicle.day_term * vehicle.day_rent / 100}元
                                                            / {vehicle.day_term}天</Col>
                                                        <Col>
                                                            <Button onClick={() => {
                                                                Dialog.confirm({
                                                                    title: `${vehicle.license} 白班 信息确认`,
                                                                    content: (
                                                                        <Row>
                                                                            <Col>
                                                                                预计结束：{vehicle.day_end_time}
                                                                            </Col>
                                                                            <Col>
                                                                                实际结束：
                                                                                <DatePicker
                                                                                    defaultValue={this.state.rentDate}
                                                                                    format="YYYY-MM-DD"
                                                                                    allowClear={false}
                                                                                    onChange={value => {
                                                                                        this.setState({rentDate: value});
                                                                                    }}/>
                                                                            </Col>
                                                                            <br/>
                                                                            <Col>
                                                                                <Input
                                                                                    defaultValue={this.state.rent}
                                                                                    onChange={e => {
                                                                                        this.setState({rent: e.target.value})
                                                                                    }}
                                                                                    addonBefore="实际租金"/>
                                                                            </Col>
                                                                            <br/>
                                                                            <Col>
                                                                                <Textarea
                                                                                    defaultValue={this.state.comment}
                                                                                    onChange={e => {
                                                                                        this.setState({comment: e.target.value})
                                                                                    }}
                                                                                    placeholder="备注"/>
                                                                            </Col>
                                                                        </Row>
                                                                    ),
                                                                    width: 300,
                                                                    onOk: () => {
                                                                        const rent = parseInt(this.state.rent);
                                                                        if (!rent) {
                                                                            return;
                                                                        }
                                                                        vehicleStore.chargeRent({
                                                                            rentId: vehicle.id,
                                                                            date: this.state.rentDate.format('X'),
                                                                            rent: rent,
                                                                            comment: this.state.comment,
                                                                            type: 0
                                                                        }).then(data => {
                                                                            if (data.status === 0) {
                                                                                this.setState({
                                                                                    rentDate: moment(),
                                                                                    rent: null,
                                                                                    comment: null
                                                                                });
                                                                                Message.success(data.info);
                                                                            } else {
                                                                                Message.warning(data.info);
                                                                            }
                                                                        })
                                                                    }
                                                                })
                                                            }}>收租金</Button>
                                                        </Col>
                                                    </Row>
                                                ) : (
                                                    <Row>
                                                        <Col>班次：白班</Col>
                                                        <Col>
                                                            <Button><Link to="/">去租车</Link></Button>
                                                        </Col>
                                                    </Row>
                                                )
                                            }
                                            <Row style={{height: 15}}/>
                                            {
                                                vehicle.night_driver ? (
                                                    <Row>
                                                        <Col>班次：夜班</Col>
                                                        <Col>驾驶员：{vehicle.night_driver}（{vehicle.night_identity}）</Col>
                                                        <Col>手机号码：<a
                                                            href={`tel:${vehicle.night_phone}`}>{vehicle.night_phone}</a></Col>
                                                        <Col>时间：{vehicle.night_begin_time} 至 {vehicle.night_end_time}</Col>
                                                        <Col>租金：{vehicle.night_term * vehicle.night_rent / 100}元
                                                            / {vehicle.night_term}天</Col>
                                                        <Col>
                                                            <Button onClick={() => {
                                                                Dialog.confirm({
                                                                    title: `${vehicle.license} 夜班 信息确认`,
                                                                    content: (
                                                                        <Row>
                                                                            <Col>
                                                                                预计结束：{vehicle.night_end_time}
                                                                            </Col>
                                                                            <Col>
                                                                                实际结束：
                                                                                <DatePicker
                                                                                    defaultValue={this.state.rentDate}
                                                                                    format="YYYY-MM-DD"
                                                                                    allowClear={false}
                                                                                    onChange={value => {
                                                                                        this.setState({rentDate: value});
                                                                                    }}/>
                                                                            </Col>
                                                                            <br/>
                                                                            <Col>
                                                                                <Input
                                                                                    defaultValue={this.state.rent}
                                                                                    onChange={e => {
                                                                                        this.setState({rent: e.target.value})
                                                                                    }}
                                                                                    addonBefore="实际租金"/>
                                                                            </Col>
                                                                            <br/>
                                                                            <Col>
                                                                                <Textarea
                                                                                    defaultValue={this.state.comment}
                                                                                    onChange={e => {
                                                                                        this.setState({comment: e.target.value})
                                                                                    }}
                                                                                    placeholder="备注"/>
                                                                            </Col>
                                                                        </Row>
                                                                    ),
                                                                    width: 300,
                                                                    onOk: () => {
                                                                        const rent = parseInt(this.state.rent);
                                                                        if (!rent) {
                                                                            return;
                                                                        }
                                                                        vehicleStore.chargeRent({
                                                                            rentId: vehicle.id,
                                                                            date: this.state.rentDate.format('X'),
                                                                            rent: rent,
                                                                            comment: this.state.comment,
                                                                            type: 1
                                                                        }).then(data => {
                                                                            if (data.status === 0) {
                                                                                this.setState({
                                                                                    rentDate: moment(),
                                                                                    rent: null,
                                                                                    comment: null
                                                                                });
                                                                                Message.success(data.info);
                                                                            } else {
                                                                                Message.warning(data.info);
                                                                            }
                                                                        })
                                                                    }
                                                                })
                                                            }}>收租金</Button>
                                                        </Col>
                                                    </Row>
                                                ) : (
                                                    <Row>
                                                        <Col>班次：夜班</Col>
                                                        <Col>
                                                            <Button><Link to="/">去租车</Link></Button>
                                                        </Col>
                                                    </Row>
                                                )
                                            }
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
                                total={vehicleList.length}
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