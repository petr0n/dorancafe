var gulp         	= require('gulp');
var gutil        	= require('gulp-util');
var rename       	= require('gulp-rename');
var uglify       	= require('gulp-uglify');
var browserify   	= require('browserify');
var watchify     	= require('watchify');
var streamify    	= require('gulp-streamify');
var plumber      	= require('gulp-plumber');
var browserSync  	= require('browser-sync');
var handleErrors 	= require('../util/handleErrors');
var paths        	= require('../config').paths;
var source 		 	= require('vinyl-source-stream')
var assign 		 	= require('lodash.assign');

var admin = {
	sourceFile: paths.scripts_admin + '/dc_app.js',
	destFolder: paths.dist_admin + '/',
	destFile: 'dc_app.js'
}

var pub = {
	sourceFile: paths.scripts_public + '/dc_public_app.js',
	destFolder: paths.dist_public + '/',
	destFile: 'dc_public_app.js'
}

// Hack to enable configurable watchify watching
var watching = false
gulp.task('enable-watch-mode', function() {
	watching = true
});

// add custom browserify options here
// var customOpts = {
//   entries: [ admin.sourceFile, pub.sourceFile ],
//   debug: true
// };
// var opts = assign({}, watchify.args, customOpts);
// var b = watchify(browserify(opts)); 

// // add transformations here
// // i.e. b.transform(coffeeify);

// gulp.task('js', bundle); // so you can run `gulp js` to build the file
// b.on('update', bundle); // on any dep update, runs the bundler
// b.on('log', gutil.log); // output build logs to terminal

// // gulp.task('js', function(admin){
// // 	bundle(admin.destFile, admin.destFolder);
// // });


// function bundle() {
// 	return b.bundle()
// 		.on('error', gutil.log.bind(gutil, 'Browserify Error'))
// 		.pipe(source(admin.destFile))
// 		//.pipe(rename({ suffix: '.min' }))
// 		.pipe(gulp.dest(admin.destFolder))
// 		.pipe(browserSync.reload({ stream: true }));
// }

gulp.task('js', function(){

	var b = watchify(browserify( 
		assign( {}, 
			watchify.args, {
				entries: [ admin.sourceFile ],
				debug: true
			}
		))
	); 

	bundle_admin(); // so you can run `gulp js` to build the file
	b.on('update', bundle_admin); // on any dep update, runs the bundler
	b.on('log', gutil.log); // output build logs to terminal


	function bundle_admin() {
		return b.bundle()
			.on('error', gutil.log.bind(gutil, 'Browserify Error [admin]'))
			.pipe(source(admin.destFile))
			//.pipe(rename({ suffix: '.min' }))
			.pipe(gulp.dest(admin.destFolder))
			.pipe(browserSync.reload({ stream: true }));
	}
});

gulp.task('js_public', function(){

	var b = watchify(browserify( 
		assign( {}, 
			watchify.args, {
				entries: [ pub.sourceFile ],
				debug: true
			}
		))
	); 

	bundle_pub(); // so you can run `gulp js` to build the file
	b.on('update', bundle_pub); // on any dep update, runs the bundler
	b.on('log', gutil.log); // output build logs to terminal


	function bundle_pub() {
		return b.bundle()
			.on('error', gutil.log.bind(gutil, 'Browserify Error [pub]'))
			.pipe(source(pub.destFile))
			//.pipe(rename({ suffix: '.min' }))
			.pipe(gulp.dest(pub.destFolder))
			.pipe(browserSync.reload({ stream: true }));
	}
});