var gulp    = require('gulp');
//var webpack = require('gulp-webpack-build');
var path    = require('path');
var paths   = require('../config').paths;

gulp.task('watch', ['js'], function() {
	gulp.watch([paths.styles + '/**/*.scss'], ['styles']);
	
	// Watch public styles
	gulp.watch(paths.public_styles + '/**/*.scss', ['publicStyles']);

	// // Watch admin styles
	// gulp.watch(paths.styles + '/admin/admin.scss', ['adminStyles']);

	// // Watch admin scripts
	// gulp.watch(paths.scripts + '/admin/admin.js', ['adminScripts']);
});
// gulp.task('watch', ['watchify'], function() {
// 	// Watch theme .scss files
// 	gulp.watch([
// 		paths.styles + '/**/*.less',
// 		'!' + paths.styles + '/admin/**'
// 	], ['styles']);


// 	// // Watch images
// 	// gulp.watch(paths.images + '/**', ['images']);

// });
