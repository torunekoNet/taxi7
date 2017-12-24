import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Input, Row, Col, Message, Form, Button} from 'td-ui';

const FormItem = Form.Item;
const FormControl = Form.Control;
const Textarea = Input.Textarea;

@Form.create()
@inject('productStore')
@observer
export default class Product extends Component {

    handleSubmit = e => {
        e.preventDefault();

        const {productStore} = this.props;
        this.props.form.validateFields((err, values) => {
            if (err) {
                return;
            }

            productStore.salesProduct({
                'productId': 60,
                'amount': parseInt(values.amount),
                'price': 1,
                'to': values.to,
                'comment': values.comment || ''
            }).then(res => {
                if (res.status === 0) {
                    Message.success(res.info);
                    productStore.setShowSalesPanel(false);
                    this.props.form.resetFields();
                } else {
                    Message.error(res.info);
                }
            });
        });
    };

    render() {
        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <p>其他（备注标明：新旧件，哪里来，用哪个车上）</p>
                    <br/>
                    <Form onSubmit={this.handleSubmit}>
                        <FormItem wrapperCol={{span: 20}}>
                            <FormControl name="amount" initialValue={1}
                                         rules={[{
                                             required: true,
                                             type: 'number',
                                             message: '请输入数量',
                                             transform: e => parseInt(e)
                                         }]}>
                                <Input addonBefore="数量"/>
                            </FormControl>
                        </FormItem>
                        <FormItem wrapperCol={{span: 20}}>
                            <FormControl name="to" rules={[{required: true, message: '请输入去向'}]}>
                                <Input addonBefore="去向"/>
                            </FormControl>
                        </FormItem>
                        <FormItem wrapperCol={{span: 20}}>
                            <FormControl name="comment">
                                <Textarea placeholder='备注内容'/>
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