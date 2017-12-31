import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import moment from 'moment';
import {Input, Row, Col, Message, Form, Button, AutoComplete, DatePicker, Radio, Dialog} from 'td-ui';

const FormItem = Form.Item;
const FormControl = Form.Control;
const RadioGroup = Radio.RadioGroup;

const types = ["白班", "夜班", "全天"];

@Form.create()
@inject('rentalStore')
@observer
export default class Rental extends Component {

    handleSubmit = e => {
        e.preventDefault();

        this.props.form.validateFields((err, values) => {
            if (err) {
                return;
            }

            const {rentalStore} = this.props;
            const days = values.endTime.diff(values.beginTime, 'days')

            Dialog.confirm({
                title: '信息确认',
                content: (
                    <Row>
                        <Col>
                            出租车: {values.license}
                        </Col>
                        <Col>
                            驾驶员: {values.driver}({values.identity})
                        </Col>
                        <Col>
                            开始时间: {values.beginTime.format('YYYY-MM-DD')}
                        </Col>
                        <Col>
                            预计到期: {values.endTime.format('YYYY-MM-DD')}
                        </Col>
                        <Col>
                            班次：{types[values.type - 1]}
                        </Col>
                        <Col>
                            日租金: {values.rent} 元
                        </Col>
                        <Col>
                            预计: {days * values.rent} 元 / {days} 天
                        </Col>
                    </Row>
                ),
                width: 300,
                onOk: () => {

                    rentalStore.create({
                        license: values.license,
                        driver: values.driver,
                        identity: values.identity,
                        phone: values.phone,
                        begin: values.beginTime.format('X'),
                        end: values.endTime.format('X'),
                        type: values.type - 1,
                        rent: values.rent,
                        term: days
                    }).then(data => {
                        if (data.status === 0) {
                            Message.success(data.info);
                            rentalStore.setDriverName(undefined);
                            this.props.form.resetFields();
                        } else {
                            Message.warning(data.info);
                        }
                    });
                }
            });
        });
    };

    render() {
        const {rentalStore} = this.props;
        const {driver, vehicleList, driverList} = rentalStore;

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
                            <FormControl name="license" rules={[{required: true, message: '请输入汽车号牌'}]}>
                                <AutoComplete
                                    dataSource={vehicleList.map(v => {
                                        return {text: v.license, value: v.license}
                                    })}
                                    optionLabelProp="text"
                                    placeholder="汽车号牌"
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
                            <FormControl name="driver" rules={[{required: true, message: '请输入驾驶员姓名'}]}>
                                <AutoComplete
                                    dataSource={driverList.map(d => {
                                        return {text: d.name, value: d.name}
                                    })}
                                    optionLabelProp="text"
                                    placeholder="驾驶员姓名"
                                    onSelect={value => {
                                        rentalStore.setDriverName(value)
                                    }}
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
                            label="证件号码">
                            <FormControl name="identity"
                                         initialValue={driver.identity}
                                         rules={[{required: true, message: '请输入驾驶员证件号码'}]}>
                                <Input placeholder="驾驶员证件号码"/>
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
                            label="手机号码">
                            <FormControl name="phone"
                                         initialValue={driver.phone}
                                         rules={[{required: true, message: '请输入驾驶员手机号码'}]}>
                                <Input placeholder="驾驶员手机号码"/>
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
                            label="租车时间">
                            <FormControl name="beginTime" initialValue={moment()}>
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
                            label="预计到期">
                            <FormControl name="endTime" initialValue={moment().add(10, 'days')}>
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
                            label="班次">
                            <FormControl name="type" initialValue={1}>
                                <RadioGroup>
                                    <Radio value={1}>白班</Radio>
                                    <Radio value={2}>夜班</Radio>
                                    <Radio value={3}>全天</Radio>
                                </RadioGroup>
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
                            label="日租金">
                            <FormControl name="rent" rules={[{
                                required: true,
                                type: 'number',
                                message: '请输入日租金',
                                transform: e => parseInt(e)
                            }]}>
                                <Input placeholder="日租金"/>
                            </FormControl>
                        </FormItem>
                        <Row>
                            <Col offset={4} span={4}>
                                <Button type="primary" htmlType="submit" style={{marginRight: 20}}>提交</Button>
                            </Col>
                        </Row>
                    </Form>
                </div>
            </div>
        )
    }
}