// https://webformyself.com/gulp-dlya-nachinayushhix/
// https://webformyself.com/urok-1-gulp-chto-takoe-gulp-i-ego-ustanovka/
/*
1. Устанавливаем NODE.JS
2. Устанавливаем Gulp для всех пользователей(-g) "$ sudo npm install gulp -g"
3. В папке проекта "$ npm init" - создаём package.json
4. Устанавливаем Gulp для текущего проекта "$ npm install gulp --save-dev"
*/
var gulp = require('gulp'); // $ npm install gulp --save-dev
var sass = require('gulp-sass'); //$ npm install gulp-sass --save-dev
var browserSync = require('browser-sync');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var gulpIf = require('gulp-if');
var lazypipe = require('lazypipe');
var csso = require('gulp-csso');
var imagemin = require('gulp-imagemin');
var cache = require('gulp-cache');
var del = require('del');
var runSequence = require('run-sequence');
var less = require('gulp-less');
var combiner = require('stream-combiner2');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');



gulp.task('default', function (callback) {
	runSequence('sass', 'lessNoError', 'browserSync', 'watch',
	callback
	)
});
gulp.task('watch', function(){
	gulp.watch('app/scss/**/*.scss', ['sass']);
	gulp.watch('app/less/**/*.less', ['lessNoError']);
	gulp.watch('app/*.html', browserSync.reload); 
	gulp.watch('app/js/**/*.js', browserSync.reload); 
	// другие ресурсы
});
gulp.task('browserSync', function() {
	browserSync({server: {baseDir: 'app', index: "index.html"}})
});
gulp.task('sass', function() {
	return gulp.src('app/scss/**/*.scss')
	.pipe(sass()) // используем gulp-sass
	.pipe(gulp.dest('app/css/'))
	.pipe(browserSync.reload({stream: true}))
});
gulp.task('less', function() {
	return gulp.src('app/less/**/*.less')
	.pipe(less().on('error', function(){console.log("Error!")})) // используем gulp-less
	.pipe(gulp.dest('app/css/'))
	.pipe(browserSync.reload({stream: true}))
});
gulp.task('lessNoError', function() {
	return combiner.obj([
		gulp.src('app/less/**/*.less'),
		less(),
		gulp.dest('app/css/'),
		browserSync.reload({stream: true})
	])
	.on('error', console.error.bind(console));
});




gulp.task('useref', function(){
  return gulp.src('app/*.html')
 .pipe(useref())
 .pipe(gulp.dest('dist'))
});
gulp.task('uglify', function(){
	return gulp.src('dist/js/**/*.js')
	.pipe(sourcemaps.init())
	.pipe(uglify()) 
	.pipe(sourcemaps.write('../maps'))
	.pipe(gulp.dest('dist/js'))
});
gulp.task('mincss', function(){
	return gulp.src('dist/css/**/*.css')
	.pipe(sourcemaps.init())
	.pipe(csso()) 
	.pipe(sourcemaps.write('../maps'))
	.pipe(gulp.dest('dist/css'))
});
gulp.task('autoprefix', function(){
	return gulp.src('dist/css/**/*.css')
	.pipe(autoprefixer({
		browsers: ['last 5 versions'],
		cascade: false
	})) 
	.pipe(gulp.dest('dist/css'))
});

gulp.task('images', function(){
	return gulp.src('app/images/**/*.+(png|jpg|jpeg|gif|svg)')
	.pipe(cache(imagemin({
		verbose: true
	})))
	.pipe(gulp.dest('dist/images'))
});
gulp.task('fonts', function() {
  return gulp.src('app/fonts/**/*')
  .pipe(gulp.dest('dist/fonts'))
});
gulp.task('clean', function(callback) {
  del('dist');
  return cache.clearAll(callback);
});
gulp.task('clean:dist', function(){
  del(['dist/**/*', '!dist/images', '!dist/images/**/*'])
});
gulp.task('build', function (callback) {
  runSequence('clean:dist', 'sass', 'less', 'useref', 'uglify', 'autoprefix', 'mincss', 'images', 'fonts', callback)
});


