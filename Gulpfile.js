var gulp 	= require('gulp');
var sass 	= require('gulp-sass');
//var cssnano = require('gulp-cssnano');
//var autoprefixer = require('gulp-autoprefixer');

//convertir estilos
gulp.task('styles', function() {
    gulp.src('scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./'));
});

//autoprefixer
/*
gulp.task('autoprefixer', function () {
	return gulp.src('style.css')
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('./'));
});
*/

//minificar
/*
gulp.task('minificar', function() {
    return gulp.src('./style.css')
        .pipe(cssnano())
        .pipe(gulp.dest('./min'));
});
*/

//Watch task
gulp.task('default',function() {
    gulp.watch('scss/**/*.scss',['styles']);
    //gulp.watch('./style.css',['autoprefixer']);
    //gulp.watch('./style.css',['minificar']);
});

