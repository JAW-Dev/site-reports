/* global __basedir */

// Require Modules.
const path = require('path');

const settings = {
	entry: {},
	process: {
		js: true,
		css: true,
		images: true,
		fonts: true,
		typescript: false,
		tailwind: false
	},
	plugins: {
		CleanWebpackPlugin: true,
		MiniCssExtractPlugin: true,
		RemoveEmptyScriptsPlugin: true,
		ImageminPlugin: false,
		BundleAnalyzerPlugin: false
	}
};

if (settings.process.js === true) {
	settings.entry['js/index'] = [path.resolve(__basedir, 'assets/js/index.js')];
	settings.entry['js/admin'] = [path.resolve(__basedir, 'assets/js/admin.js')];
}

if (settings.process.typescript === true) {
	settings.entry['ts/index'] = [path.resolve(__basedir, 'assets/ts/index.ts')];
	settings.entry['ts/admin'] = [path.resolve(__basedir, 'assets/ts/admin.ts')];
}

if (settings.process.css === true) {
	settings.entry['css/index'] = [path.resolve(__basedir, 'assets/css/index.scss')];
	settings.entry['css/admin'] = [path.resolve(__basedir, 'assets/css/admin.scss')];
}

module.exports = settings;
