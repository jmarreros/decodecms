var gulp 	= require('gulp');
var sass 	= require('gulp-sass');
var concat = require('gulp-concat');

//convertir estilos
gulp.task('convertirCSS', function() {
    return gulp.src('scss/**/*.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('./dev/'));
});

//concatenar con comentarios.css
gulp.task('concatenar',['convertirCSS'], function () {
   return gulp.src('./dev/*.css')
     .pipe(concat("./style.css"))
     .pipe(gulp.dest('./'));
});


//Tarea para monitorear cambios en los archivos sass
gulp.task('watch_scss',function(){
    gulp.watch('scss/**/*.scss',['concatenar']);
});


//Default task
gulp.task('default',['watch_scss']);



