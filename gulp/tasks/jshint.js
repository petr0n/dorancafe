var gulp    = require('gulp');
var jshint  = require('gulp-jshint');
var stylish = require('jshint-stylish');
var paths   = require('../config').paths;

gulp.task('jshint', function() {
  return gulp.src([paths.scripts_admin + '/*.js', paths.scripts_public + '/*.js'])
	.pipe(jshint())
	.pipe(jshint.reporter(stylish))
	.pipe(jshint.reporter('fail'));
});
