var gulp        = require('gulp');
var browserSync = require('browser-sync');
var domain      = require('../config').domain;
var paths       = require('../config').paths;

gulp.task('browserSync', ['watch'], function() {
  browserSync({
	proxy: domain,
	browser: 'firefox',
	files: [
	  paths.dist_admin + '/**',
	  paths.dist_public + '/**',
	  // Exclude Map files
	  // '!' + paths.dist + '/**.map'
	]
  });
});
