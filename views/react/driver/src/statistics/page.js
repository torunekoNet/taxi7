import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Link} from 'react-router-dom';
import moment from 'moment';
import {Input, Row, Col, Message, Form, Button, AutoComplete, DatePicker, Radio, Table} from 'td-ui';

const Column = Table.Column;
const FormItem = Form.Item;
const FormControl = Form.Control;

@Form.create()
@inject('statisticsStore', 'rentalStore')
@observer
export default class Rental extends Component {

    constructor(props) {
        super(props);
        this.state = {
            begin: moment().add(-9, 'days'),
            end: moment(),
        }
    }

    handleSubmit = e => {
        e.preventDefault();

        this.props.form.validateFields((err, values) => {
            if (err) {
                return;
            }

            const {statisticsStore} = this.props;
            statisticsStore.doStatistic(values.license, values.driver,
                values.beginTime.format('YYYY-MM-DD'), values.endTime.format('YYYY-MM-DD'));
        });
    };

    render() {
        const {statisticsStore, rentalStore} = this.props;
        const {vehicleList, driverList} = rentalStore;
        const {statistic, totalDay, recordList, recordPage} = statisticsStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Form onSubmit={this.handleSubmit}>
                        <FormItem
                            labelCol={{
                                xs: {span: 6},
                                sm: {span: 2}
                            }}
                            wrapperCol={{
                                xs: {span: 16},
                                sm: {span: 20}
                            }}
                            label="车牌">
                            <FormControl name="license">
                                <AutoComplete
                                    dataSource={vehicleList.map(v => {
                                        return {text: v.license, value: v.license}
                                    })}
                                    placeholder="汽车号牌"
                                    filterOption={(inputValue, options) => {
                                        return options.props.children.toLowerCase().indexOf(inputValue.toLowerCase()) >= 0;
                                    }}
                                />
                            </FormControl>
                        </FormItem>
                        <FormItem
                            labelCol={{
                                xs: {span: 6},
                                sm: {span: 2}
                            }}
                            wrapperCol={{
                                xs: {span: 16},
                                sm: {span: 20}
                            }}
                            label="驾驶员">
                            <FormControl name="driver">
                                <AutoComplete
                                    dataSource={driverList.map(d => {
                                        return {text: d.name, value: d.name}
                                    })}
                                    placeholder="驾驶员姓名"
                                    filterOption={(inputValue, options) => {
                                        return options.props.children.toLowerCase().indexOf(inputValue.toLowerCase()) >= 0;
                                    }}
                                />
                            </FormControl>
                        </FormItem>
                        <FormItem
                            labelCol={{
                                xs: {span: 6},
                                sm: {span: 2}
                            }}
                            wrapperCol={{
                                xs: {span: 16},
                                sm: {span: 20}
                            }}
                            label="时间范围">
                            <FormControl name="beginTime" initialValue={this.state.begin}>
                                <DatePicker format="YYYY-MM-DD" allowClear={false}/>
                            </FormControl>
                        </FormItem>
                        <FormItem
                            labelCol={{
                                xs: {span: 6},
                                sm: {span: 2}
                            }}
                            wrapperCol={{
                                xs: {span: 16},
                                sm: {span: 20}
                            }}
                            label="时间范围">
                            <FormControl name="endTime" initialValue={this.state.end}>
                                <DatePicker format="YYYY-MM-DD" allowClear={false}/>
                            </FormControl>
                        </FormItem>
                        <Row gutter={12}>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        onClick={() => {
                                            this.setState({begin: moment().add(-9, 'days'), end: moment()})
                                        }}
                                        style={{marginRight: 20}}>十天</Button>
                            </Col>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        onClick={() => {
                                            this.setState({begin: moment().add(-1, 'month'), end: moment()})
                                        }}
                                        style={{marginRight: 20}}>一月</Button>
                            </Col>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        onClick={() => {
                                            this.setState({begin: moment().add(-3, 'month'), end: moment()})
                                        }}
                                        style={{marginRight: 20}}>三月</Button>
                            </Col>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        onClick={() => {
                                            this.setState({begin: moment().add(-6, 'month'), end: moment()})
                                        }}
                                        style={{marginRight: 20}}>半年</Button>
                            </Col>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        onClick={() => {
                                            this.setState({begin: moment().add(-1, 'year'), end: moment()})
                                        }}
                                        style={{marginRight: 20}}>一年</Button>
                            </Col>
                            <Col span={4}>
                                <Button size='small' type="primary" htmlType="submit"
                                        style={{marginRight: 20}}>搜索</Button>
                            </Col>
                        </Row>
                    </Form>
                </div>
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col>总租金：{statistic / 100}</Col>
                        <Col>总天数：{totalDay}</Col>
                        <Col>
                            <Table
                                dataSource={recordList.toJS()}
                                pagination={{
                                    current: recordPage.currentPage + 1,
                                    total: recordPage.itemCount,
                                    pageSize: recordPage.pageSize,
                                    onChange: page => statisticsStore.doStatistic(undefined, undefined, undefined, undefined, page)
                                }}
                            >
                                <Column width='25%' title="驾驶员" key="driver" dataIndex="driver"/>
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
        )
    }
}