var gulp         = require('gulp');
var gutil        = require('gulp-util');
var scss         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-clean-css');
var rename       = require('gulp-rename');
var plumber      = require('gulp-plumber');
var browserSync  = require('browser-sync');
var handleErrors = require('../util/handleErrors');
var paths        = require('../config').paths;

var dest = paths.dist + '/';

gulp.task('styles', function() {
  return gulp.src([paths.styles + '/dc_app.scss'])
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(scss())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'Opera 12.1', 'ios 6', 'android 4'))
    // .pipe(gulp.dest(dest))
    // .pipe(minifycss({ processImport: false }))
    // .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(dest))
    .pipe(browserSync.reload({
      stream: true
    }));
});
