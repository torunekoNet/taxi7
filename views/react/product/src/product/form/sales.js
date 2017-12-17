import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Input, Row, Col, Dialog, Message, Form, Radio} from 'td-ui';

const FormItem = Form.Item;
const FormControl = Form.Control;
const RadioGroup = Radio.RadioGroup;
const Textarea = Input.Textarea;

@Form.create()
@inject('productStore')
@observer
export default class SalesForm extends Component {

    handleSubmit = () => {
        const {productStore} = this.props;
        const {selectedProduct} = productStore;
        this.props.form.validateFields((err, values) => {
            if (err) {
                return;
            }

            let comment = values.type === 1 ? '新' : '旧';
            comment += (' ' + values.from + ' ' + (values.comment || ''));
            productStore.salesProduct({
                'productId': selectedProduct.id,
                'amount': parseInt(values.amount),
                'price': 1,
                'to': values.to,
                'comment': comment
            }).then(res => {
                if (res.status == 0) {
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
        const {productStore} = this.props;
        const {selectedProduct, showSalesPanel} = productStore;

        return (
            <Dialog
                title={selectedProduct.name}
                onOk={() => this.props.form.submit(this.handleSubmit)}
                onCancel={() => productStore.setShowSalesPanel(false)}
                visible={showSalesPanel}
                okText="确定"
                cancelText="取消"
                maskClosable={false}
            >
                <Form>
                    <Row>
                        <Col span={12}>
                            <FormItem>
                                <FormControl name="type" initialValue={1}>
                                    <RadioGroup>
                                        <Radio value={1}>新</Radio>
                                        <Radio value={2}>旧</Radio>
                                    </RadioGroup>
                                </FormControl>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={12}>
                            <FormItem>
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
                        </Col>
                    </Row>
                    <Row>
                        <Col span={12}>
                            <FormItem>
                                <FormControl name="from" rules={[{required: true, message: '请输入来源'}]}>
                                    <Input addonBefore="来源"/>
                                </FormControl>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={12}>
                            <FormItem>
                                <FormControl name="to" rules={[{required: true, message: '请输入去向'}]}>
                                    <Input addonBefore="去向"/>
                                </FormControl>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span={12}>
                            <FormItem>
                                <FormControl name="comment">
                                    <Textarea placeholder='备注内容'/>
                                </FormControl>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </Dialog>
        )
    }
}