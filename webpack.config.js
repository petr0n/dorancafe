var webpack = require('webpack');

module.exports = {
    debug: true,
    devtool : 'eval',

    entry: {
        app: './assets/js/dc_app.js'
    },

    output: {
        path: './assets/',
        filename: '[name].js'
    },

    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        })
    ]
};