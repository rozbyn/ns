
var gulp = require('gulp'); // $ npm install gulp --save-dev
var browserSync = require('browser-sync');
var less = require('gulp-less');
var combiner = require('stream-combiner2');


gulp.task('default', ['browserSync','lessNoError'], function(){
	gulp.watch('src/less/*.less', ['lessNoError']);
	gulp.watch('www/*.html', browserSync.reload); 
	// другие ресурсы
});

gulp.task('browserSync', function() {
	browserSync({server: {baseDir: 'www', index: "index.html"}})
});

gulp.task('less', function() {
	return gulp.src('src/less/styles.less')
	.pipe(less()) // используем gulp-less
	.pipe(gulp.dest('www/css/'))
	.pipe(browserSync.reload({stream: true}))
});

gulp.task('lessNoError', function() {
	return combiner.obj([
		gulp.src('src/less/styles.less'),
		less(),
		gulp.dest('www/css/'),
		browserSync.reload({stream: true})
	])
	.on('error', console.error.bind(console));
});


