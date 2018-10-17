var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();

gulp.task('browserSync', function() {
  browserSync.init({
    proxy: 'https://isle.localdomain',
    options: {
      reloadOnRestart: true,
      reloadDebounce: 100
    }
  });
});

gulp.task('sass', function() {
  return gulp.src('scss/**/*.scss')
  .pipe(sass({outputStyle: 'compressed'}))
  .pipe(gulp.dest('css/'))
  .pipe(browserSync.reload({
    stream:true
  }))
});

gulp.task('watch', ['browserSync', 'sass'], function() {
  gulp.watch('scss/**/*.scss', ['sass']);
  gulp.watch('templates/**/*.php', browserSync.reload);
  gulp.watch('*/**/*.php');
  gulp.watch('js/*.js', browserSync.reload);
});