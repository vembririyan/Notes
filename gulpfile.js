const { parallel } = require('gulp');
let gulp = require('gulp'),
    gutil = require('gulp-util'),
    browserSync = require('browser-sync'),
    slang = require('gulp-slang');

async function defaultTask() {
    // place code for your default task here
    gulp.task('default', async function() {

    })
}

gulp.task('watch', async function() {
    // content
    let slangChange = function(ev) {
        return gulp.src().
        pipe(slang({
            port: 4502
        }));
    };
    gulp.watch('app/Controllers/**/*.php', slangChange);
    gulp.watch('app/Views/*.php', slangChange);
    gulp.watch('public/css/*.css', slangChange);
    gulp.watch('public/js/*.js', slangChange);
});

gulp.task('browser-sync', async function() {
    // content
    browserSync.init({
        proxy: 'localhost:81',
        files: [
            'app/Controllers/*.php',
            'app/Views/*.php',
            'public/css/*.css',
            'public/js/*.js',
        ]
    })
    gutil.log('Live Reload Started');
});


exports.default = parallel('browser-sync')
    // exports.default = defaultTask