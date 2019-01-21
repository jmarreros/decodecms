var gulp  = require('gulp');
var sass  = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var pump = require('pump');

//convertir estilos
gulp.task('convertirCSS', function() {
    return gulp.src('scss/**/*.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./src/'));
});

//concatenar con comentarios.css
gulp.task('concatenar', gulp.series('convertirCSS', function () {
    return gulp.src('./src/*.css')
      .pipe(concat("./style.css"))
      .pipe(gulp.dest('./'));
 }));

//Tarea para monitorear cambios en los archivos sass
gulp.task('watch_scss',function(){
    gulp.watch(['scss/**/*.scss'],gulp.series('concatenar'));
});


//Para Javascript
gulp.task('comprimirJS', function (cb) {
    pump([
          gulp.src('src/*.js'),
          uglify(),
          gulp.dest('./js')
      ],
      cb
    );
});


gulp.task('default',gulp.series('comprimirJS','watch_scss'));