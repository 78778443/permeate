var gulp = require('gulp');
var cleancss = require('gulp-clean-css');
var csscomb = require('gulp-csscomb');
var rename = require('gulp-rename');
var sass = require('gulp-ruby-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var browsersync = require('browser-sync').create();//获取browsersync

gulp.task('build', () =>
    sass('./scss/permeate.scss')
        .on('error', sass.logError)
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(csscomb())
        .pipe(gulp.dest('./dist'))
        .pipe(cleancss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./dist'))
);
gulp.task('html', function() {
    gulp.src('*.html')
        .pipe(gulp.dest('./'))
        .pipe(browsersync.stream());
});


gulp.task('watch', function () {
    browsersync.init({
        port: 4000,
        server: {
            baseDir: ['./']
        }
    });
    gulp.watch('./scss/permeate.scss', ['build']);
    gulp.watch('./scss/*/*.scss', ['build']);
    gulp.watch('./scss/*.scss', ['build']);
    // gulp.watch('*.html', ['html']);
});

gulp.task('default', ['build','watch']);


// gulp.task("rebuild", ["build", "build2"], function () {
//   browserSync.reload();
// });