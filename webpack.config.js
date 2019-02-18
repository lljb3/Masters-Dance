const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
var OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    mode: 'development',
    resolve: {
        alias: {
            smoothscroll: path.resolve(__dirname, 'assets/js/lib/smooth-scroll.polyfills.js')
        }
    },
    entry: {
        site: './assets/js/dist/site'
    },
    output: {
        path: path.resolve(__dirname, 'assets/js'),
        filename: 'bundle.min.js'
    },
    externals: {
        jquery: 'jQuery'
    },
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                extractComments: true,
                uglifyOptions: {
                    output: {
                        comments: false,
                    },
                },
            }),
        ],
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env'],
                    }
                }
            },
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        { loader: 'css-loader' }
                    ]
                })
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader','sass-loader'],
                    publicPath: 'dist'
                })
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: '../fonts'
                    }
                }]
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin('../css/style.min.css'),
        new OptimizeCssAssetsPlugin({
            assetNameRegExp: /\.optimize\.css$/g,
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
                preset: ['default', { discardComments: { removeAll: true } }],
            },
            canPrint: true
        })
    ]
}