var gulp = require('gulp');

var postcss = require('gulp-postcss');
var connect = require('gulp-connect');
var watch = require('gulp-watch');

gulp.task('css', function () {
    return gulp.src('./public/**/*.css')
        .pipe(postcss(
           [
            require("postcss-flexibility"),
            require('postcss-import'),
            require('autoprefixer'),
            require('precss'),
            require('postcss-calc'),
            require('postcss-mixins'),
            require("postcss-selector-not")
           ]
            
        ))
        .pipe(gulp.dest('./dest'));
});

gulp.task('js', function () {
    return gulp.src('./public/**/*.js')
        .pipe(gulp.dest('./dest'));
});


gulp.task('webserver', function() {
    connect.server({
         livereload: true,
         port: 8001
    });

});

gulp.task('livereload', function() {

  gulp.src(['./public/**/*.css', './public/**/*.js'])

    .pipe(watch())

    .pipe(connect.reload());

});

gulp.task('image', function(){
    return gulp.src('./public/image/*')
        .pipe(gulp.dest('./dest/image'));
});

gulp.task('watch', function() {
    gulp.watch('./public/**/*.css', ['css']);
    gulp.watch('./public/image/*', ['image']);
    gulp.watch('./public/**/*.js', ['js']);
})

gulp.task('default', ['css', 'js', 'image', 'webserver', 'watch']);