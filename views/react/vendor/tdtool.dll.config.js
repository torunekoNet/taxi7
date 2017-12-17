const path = require('path');
const isDebug = process.env.NODE_ENV !== 'production';
module.exports = {
  entry: {
    vendor1: ['./polyfill', 'react', 'react-dom', 'mobx', 'mobx-react', 'mobx-react-router' ],
    vendor2: ['react-router','react-router-dom', 'moment', 'moment/locale/zh-cn']
  },
  path: path.resolve(process.cwd(), isDebug ? '' : '../../../../assets', 'dll'),
  debug: isDebug
};