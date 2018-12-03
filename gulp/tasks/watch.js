var gulp    = require('gulp');
//var webpack = require('gulp-webpack-build');
var path    = require('path');
var paths   = require('../config').paths;

gulp.task('watch', ['js', 'js_public'], function() {
	gulp.watch(paths.styles_admin + '/**/*.scss', ['styles']);
	
	// Watch public styles
	gulp.watch(paths.styles_public + '/**/*.scss', ['publicStyles']);

	// // Watch admin styles
	// gulp.watch(paths.styles + '/admin/admin.scss', ['adminStyles']);

	// // Watch admin scripts
	// gulp.watch(paths.scripts + '/admin/admin.js', ['adminScripts']);
});

// 	// // Watch images
// 	// gulp.watch(paths.images + '/**', ['images']);

// });
