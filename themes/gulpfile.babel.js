import autoprefixer from 'autoprefixer';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';

const $ = gulpLoadPlugins();

// Base path.
const basePath = './';
const sassPath = basePath + 'sass/';
const distPath = basePath + 'simple-line/';

const browsers = [
    '> 3%'
];

// Task of sass compile.
gulp.task('sass', () => {
    const target = [
        sassPath + 'style.scss'
    ];
    return gulp.src(target)
        .pipe($.sassLint())
        .pipe($.sassLint.format())
        .pipe($.sassLint.failOnError())
        .pipe($.sass({
            outputStyle: 'expanded'
        }))
        .pipe($.postcss([
            autoprefixer({
                brwosers: browsers
            })
        ]))
        .pipe(gulp.dest(distPath));
});

// Task of compile theme assets by watch.
gulp.task('sass:watch', () => {
    const target = [
        sassPath + '**/*.scss'
    ];
    gulp.watch(target, ['sass']);
});

// Task of running.
gulp.task('watch', ['sass:watch']);
gulp.task('build', ['sass']);
gulp.task('default', ['watch']);
