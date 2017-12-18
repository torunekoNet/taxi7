import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import {Table, Button, Input, Row, Col, Dialog, Message} from 'td-ui';
import ProductForm from './form/product';
import SalesForm from './form/sales';

const Column = Table.Column;


@inject('productStore')
@observer
export default class Product extends Component {

    renderAddPanel() {
        return (
            <ProductForm/>
        );
    }

    renderTable() {
        const {productStore} = this.props;
        const {list, pager, searchNumber, searchName} = productStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={6}>
                            <Input value={searchNumber} addonBefore="编号" style={{width: 150}}
                                   onChange={e => productStore.setSearchNumber(e.target.value)
                                   }/>
                        </Col>
                        <Col span={1}/>
                        <Col span={6}>
                            <Input value={searchName} addonBefore="名称" style={{width: 150}}
                                   onChange={e => productStore.setSearchName(e.target.value)
                                   }/>
                        </Col>
                        <Col span={1}/>
                        <Col span={3}>
                            <Button onClick={() => productStore.searchProducts(searchNumber, searchName, 1)}>搜索</Button>
                        </Col>
                        <Col offset={4} span={3}>
                            <Button onClick={() => productStore.setShowProductAddPanel(true)}>添加项</Button>
                        </Col>
                    </Row>
                    <Row style={{height: 15}}/>
                    <Row>
                        <Col span={24}>
                            <Table
                                dataSource={list.toJS()}
                                pagination={{
                                    current: pager.currentPage + 1,
                                    total: pager.itemCount,
                                    pageSize: pager.pageSize,
                                    onChange: (page) => productStore.searchProducts(searchNumber, searchName, page)
                                }}
                                rowKey="number"
                                scroll={{x: 1200}}
                            >
                                <Column title="编号" dataIndex="number" key="number"/>
                                <Column title="名称" dataIndex="name" key="name"/>
                                <Column title="数量" dataIndex="sales" key="sales" width={100}/>
                                <Column title="描述" dataIndex="comment" key="comment"/>
                                <Column title="操作" dataIndex="operation" key="operation" width="180px" fixed="right"
                                        render={(text, record) => (
                                            <ul className="account-overview-operation">
                                                <li>
                                                    <Button type="primary" onClick={() => {
                                                        productStore.setSelectedProduct(record);
                                                        productStore.setShowSalesPanel(true);
                                                    }}>装配</Button>
                                                </li>
                                                <li>
                                                    <Button type="primary" onClick={() => Dialog.confirm({
                                                        title: '你确定要删除此项吗？',
                                                        content: record.name,
                                                        onOk: () => {
                                                            productStore.deleteProduct(record.id).then(
                                                                res => res.status == 0 ? Message.success(res.info) : Message.error(res.info)
                                                            )
                                                        }
                                                    })}>删除</Button>
                                                </li>
                                            </ul>
                                        )}/>
                            </Table>
                        </Col>
                    </Row>
                    <SalesForm/>
                </div>
            </div>
        );
    }

    render() {
        const {productStore} = this.props;
        const {showProductAddPanel} = productStore;

        return !showProductAddPanel ? this.renderTable() : this.renderAddPanel();
    }
}