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


gulp.task('styles', function() {
  return gulp.src(paths.styles_admin + '/dc_app.scss')
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(scss())
    .pipe(autoprefixer())
    // .pipe(minifycss({ processImport: false }))
    // .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.dist_admin + '/'))
    .pipe(browserSync.reload({
      stream: true
    }));
});
gulp.task('publicStyles', function() {
  return gulp.src(paths.styles_public + '/dc_public_app.scss')
    .pipe(plumber({
      errorHandler: handleErrors
    }))
    .pipe(scss())
    .pipe(autoprefixer())
    // .pipe(minifycss({ processImport: false }))
    // .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.dist_public + '/'))
    .pipe(browserSync.reload({
      stream: true
    }));
});
