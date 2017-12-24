const path = require('path');
const pkg = require('./package.json');
const webpack = require('webpack');
const Config = require('tdtool').Config;
const CleanWebpackPlugin = require('clean-webpack-plugin');
const TARGET = process.env.npm_lifecycle_event;
const isDebug = process.env.NODE_ENV !== 'production';
const dllPath = path.resolve(__dirname, isDebug ? '../vendor' : '../../../../assets', 'dll');
const vendor1 = new webpack.DllReferencePlugin({
    manifest: require(path.join(dllPath, 'vendor1.js.json')),
    name: 'vendor1_library'
});
const vendor2 = new webpack.DllReferencePlugin({
    manifest: require(path.join(dllPath, 'vendor2.js.json')),
    name: 'vendor2_library'
});
const CopyWebpackPlugin = require('copy-webpack-plugin');

const clientConfig = new Config({
    entry: {
        [pkg.name]: './src/main'
    },
    sourceMap: true,
    devtool: "source-map",
    filename: isDebug ? '[name].js?[hash]' : '[name].js',
    minimize: !isDebug,
    extends: [['react', {
        plugins: [
            ["import", {libraryName: "td-ui", style: true}]
        ]
    }], ['less', {
        extractCss: {
            filename: isDebug ? '[name].css?[hash]' : '[name].css',
            allChunks: true
        },
        happypack: true
    }]],
    env: {
        __DEV__: isDebug
    },
    template: (isDebug && TARGET !== 'build') ? '../product.html' : false,
    devServer: {
        inline: true,
        historyApiFallback: true,
        hot: true,
        disableHostCheck: true,
        proxy: {
            '**': 'http://127.0.0.1'
        }
    }
});

clientConfig.add('plugin.vendor1', vendor1);
clientConfig.add('plugin.vendor2', vendor2);

if (isDebug) {
    if (TARGET !== 'build') {
        clientConfig.add('plugin.copydll', new CopyWebpackPlugin([{from: '../vendor/dll', to: 'dll'}]));
        clientConfig.add('plugin.copytdcicon', new CopyWebpackPlugin([{from: '../vendor/tdcicon', to: 'tdcicon'}]));
    }
    clientConfig.add('output.path', path.join(__dirname, 'dist'));
} else {
    const releasePath = path.resolve(__dirname, '../../../../assets');
    clientConfig.add(
        'plugin.CleanWebpackPlugin',
        new CleanWebpackPlugin(
            [pkg.name],
            {
                root: releasePath,                      //根目录
                verbose: true,        　　　　　　　　　　//开启在控制台输出信息
                dry: false        　　　　　　　　　　//启用删除文件
            }
        )
    );
    clientConfig.add('output.path', path.resolve(releasePath, pkg.name));
    clientConfig.add('output.publicPath', isDebug ? '/assets/product/' : '//assets.toruneko.net/taxi7/product/');
}
clientConfig.add('output.chunkFilename', '[name].[chunkhash].chunk.js');

module.exports = clientConfig.resolve();