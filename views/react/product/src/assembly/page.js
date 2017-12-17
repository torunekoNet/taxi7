import React, {Component} from 'react';
import {observer, inject} from 'mobx-react';
import moment from 'moment';
import {Table, Button, Input, Row, Col, Message} from 'td-ui';

const Column = Table.Column;


@inject('assemblyStore')
@observer
export default class Assembly extends Component {

    render() {
        const {assemblyStore} = this.props;
        const {list, pager, to, comment} = assemblyStore;

        return (
            <div className="account-app account-content">
                <div className="account-content-container" style={{padding: 10}}>
                    <Row>
                        <Col span={6}>
                            <Input value={to} addonBefore="去向" style={{width: 150}}
                                   onChange={e => assemblyStore.setTo(e.target.value)
                                   }/>
                        </Col>
                        <Col span={1}/>
                        <Col span={6}>
                            <Input value={comment} addonBefore="备注" style={{width: 150}}
                                   onChange={e => assemblyStore.setComment(e.target.value)
                                   }/>
                        </Col>
                        <Col span={1}/>
                        <Col span={3}>
                            <Button onClick={() => assemblyStore.searchAssembly(to, comment, 1)}>搜索</Button>
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
                                    onChange: (page) => assemblyStore.searchAssembly(to, comment, page)
                                }}
                                rowKey="id"
                            >
                                <Column title="名称" dataIndex="cargo_name" key="cargo_name"/>
                                <Column title="数量" dataIndex="amount" key="amount"/>
                                <Column title="去向" dataIndex="to" key="to"/>
                                <Column title="时间" dataIndex="gmt_create" key="gmt_create"
                                        render={time => moment(parseInt(time) * 1000).format('YYYY-MM-DD HH:mm:ss')}/>
                                <Column title="描述" dataIndex="comment" key="comment" width={300}/>
                            </Table>
                        </Col>
                    </Row>
                </div>
            </div>
        )
    }
}