import React, { PureComponent } from 'react';
import { Icon } from 'td-ui';
import _ from 'lodash';

export default class Shuttle extends PureComponent {
  render() {
    const { dataSource, onSelect, onUnselect, render, 
      width, height, titles, rowKey, onSourceSearch, onTargetSearch } = this.props;
    const { source, target } = titles;
    const srcDatas = dataSource.source;
    const tgtDatas = dataSource.target;
    return (
      <div className="td-shuttle" style={{ height: height + 100 }}>
        <div className="td-shuttle-box" style={{ width }}>
          <div className="td-shuttle-box-title">
            <div>
              <span className="td-shuttle-box-title-left">{source[0]}</span>
              <span className="td-shuttle-box-title-right">{source[1]}</span>
            </div>
          </div>
          <div className="td-shuttle-box-search">
            <input placeholder="请输入关键词查询" type="text" onChange={e => onSourceSearch(e.target.value)}/>
            <Icon type="search" />
          </div>
          <div className="td-shuttle-box-list" style={{ height }}>
            <ul>
              {
                srcDatas.map(record => (
                  <li key={record[rowKey]} onClick={() => onSelect(record)} className="td-shuttle-box-list-item">
                    <span>
                      <div className="td-shuttle-box-list-item-left">
                        <div>{record[rowKey]}</div>
                        <div>{record.description}</div>
                      </div>
                      <div className="td-shuttle-box-list-item-right">
                        系统
                      </div>
                    </span>
                  </li>
                ))
              }
            </ul>
          </div>
        </div>
        <div className="td-shuttle-box" style={{ width, marginLeft: 20 }}>
          <div className="td-shuttle-box-title">
            <div>
              <span className="td-shuttle-box-title-left">{target[0]}</span>
              <span className="td-shuttle-box-title-right">{target[1]}</span>
            </div>
          </div>
          <div className="td-shuttle-box-search">
            <input placeholder="请输入关键词查询" type="text" onChange={e => onTargetSearch(e.target.value)}/>
            <Icon type="search" />
          </div>
          <div className="td-shuttle-box-list" style={{ height }}>
            <ul>
              {
                tgtDatas.map(record => (
                  <li key={record[rowKey]} onClick={() => onUnselect(record)} className="td-shuttle-box-list-item">
                    <span>
                      <div className="td-shuttle-box-list-item-left">
                        <div>{record[rowKey]}</div>
                        <div>{record.description}</div>
                      </div>
                      <div className="td-shuttle-box-list-item-right">
                        系统
                      </div>
                    </span>
                  </li>
                ))
              }
            </ul>
          </div>
        </div>
      </div>
    );
  }
}