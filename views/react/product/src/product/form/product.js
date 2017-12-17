import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Button, Col, Form, Input, Message, Row} from 'td-ui';

const FormItem = Form.Item;
const FormControl = Form.Control;
const Textarea = Input.Textarea;

@Form.create()
@inject('productStore')
@observer
export default class ProductForm extends Component {

    handleSubmit = e => {
        e.preventDefault();

        const {productStore} = this.props;
        this.props.form.validateFields((err, values) => {
            if (err) {
                return;
            }

            productStore.createProduct({
                number: values.number,
                name: values.name,
                price: 1,
                comment: values.comment || ''
            }).then(
                res => {
                    if (res.status == 0) {
                        Message.success(res.info);
                        productStore.setShowProductAddPanel(false);
                    } else {
                        Message.error(res.info);
                    }
                }
            );
        });
    };

    render() {
        const {productStore} = this.props;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Form onSubmit={this.handleSubmit}>
                        <FormItem
                            labelCol={{span: 3}}
                            wrapperCol={{span: 10}}
                            label="编号"
                        >
                            <FormControl name="number" rules={[{required: true, message: '请输入编号'}]}>
                                <Input/>
                            </FormControl>
                        </FormItem>
                        <FormItem
                            labelCol={{span: 3}}
                            wrapperCol={{span: 10}}
                            label="名称"
                        >
                            <FormControl name="name" rules={[{required: true, message: '请输入名称'}]}>
                                <Input/>
                            </FormControl>
                        </FormItem>
                        <FormItem
                            labelCol={{span: 3}}
                            wrapperCol={{span: 10}}
                            label="备注"
                        >
                            <FormControl name="comment">
                                <Textarea/>
                            </FormControl>
                        </FormItem>
                        <Row>
                            <Col offset={4} span={4}>
                                <Button type="primary" htmlType="submit" style={{marginRight: 20}}>提交</Button>
                            </Col>
                            <Col span={4}>
                                <Button onClick={() => productStore.setShowProductAddPanel(false)}>返回</Button>
                            </Col>
                        </Row>
                    </Form>
                </div>
            </div>
        );
    }
}