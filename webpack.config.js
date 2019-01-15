var webpack = require('webpack');

module.exports = {
	debug: true,
	devtool : 'eval',

	entry: {
		// app: './assets/js/dc_app.js',
		// pub: './public/dist/dc_public_app.js'
		'admin/dist': './admin/js/dc_app.js',
		'public/dist': './public/dist/dc_public_app.js'
	},

	output: {
		// path: './assets/',
		// filename: '[name].js'
		path: path.resolve(__dirname, ''),
		filename: '[name].js'
	},

	plugins: [
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			'window.$': 'jquery'
		}),
		new webpack.optimize.UglifyJsPlugin({
			compress: {
				warnings: false
			}
		})
	]
};