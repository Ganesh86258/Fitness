// Include gulp
var gulp = require('gulp');

// Include Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var cssmin = require('gulp-cssmin');

// Lint Task
gulp.task('lint', function () {
    return gulp.src([
            '../js/modules.js',
            '../js/blog.js',
            '../js/like.js'
        ])
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Concatenate
gulp.task('all', function () {
    return gulp.src([
        '../js/modules/global.js',
        '../js/modules/common.js',
        '../js/modules/headers.js',
        '../js/modules/title.js',
        '../js/modules/shortcodes.js',
        '../js/modules/woocommerce.js',
        '../js/modules/portfolio.js'
    ]).pipe(concat('modules.js'))
        .pipe(gulp.dest('../js'));
});

gulp.task('third_party', function () {
    return gulp.src([
        '../js/modules/plugins/jquery.appear.js',
        '../js/modules/plugins/modernizr.custom.85257.js',
        '../js/modules/plugins/jquery.appear.js',
        '../js/modules/plugins/jquery.hoverIntent.min.js',
        '../js/modules/plugins/jquery.plugin.js',
        '../js/modules/plugins/jquery.countdown.min.js',
        '../js/modules/plugins/owl.carousel.min.js',
        '../js/modules/plugins/parallax.min.js',
        '../js/modules/plugins/select2.min.js',
        '../js/modules/plugins/easypiechart.js',
        '../js/modules/plugins/jquery.waypoints.min.js',
        '../js/modules/plugins/Chart.min.js',
        '../js/modules/plugins/counter.js',
        '../js/modules/plugins/absoluteCounter.js',
        '../js/modules/plugins/fluidvids.min.js',
        '../js/modules/plugins/jquery.prettyPhoto.js',
        '../js/modules/plugins/jquery.nicescroll.min.js',
        '../js/modules/plugins/ScrollToPlugin.min.js',
        '../js/modules/plugins/TweenLite.min.js',
        '../js/modules/plugins/TimelineLite.min.js',
        '../js/modules/plugins/CSSPlugin.min.js',
        '../js/modules/plugins/EasePack.min.js',
        '../js/modules/plugins/jquery-scrollspy.js',
        '../js/modules/plugins/jquery.mixitup.min.js',
        '../js/modules/plugins/jquery.multiscroll.min.js',
        '../js/modules/plugins/jquery.waitforimages.js',
        '../js/modules/plugins/jquery.infinitescroll.min.js',
        '../js/modules/plugins/jquery.easing.1.3.js',
        '../js/modules/plugins/skrollr.js',
        '../js/modules/plugins/slick.min.js',
        '../js/modules/plugins/bootstrapCarousel.js',
        '../js/modules/plugins/jquery.touchSwipe.min.js',
        '../js/modules/plugins/jquery.flexslider-min.js'
    ]).pipe(concat('third-party.js'))
        .pipe(gulp.dest('../js'));
});

// Minify JS
gulp.task('minifyjs', function () {
    return gulp.src([
        '../js/modules.js',
        '../js/blog.js',
        '../js/like.js',
        '../js/third-party.js'
    ]).pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('../js'));
});

// Compile Our Sass
gulp.task('sass', function () {
    return gulp.src('../css/scss/*.scss')
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(sourcemaps.write('../css'))
        .pipe(gulp.dest('../css'))
});

gulp.task('minifycss', function () {
    return gulp.src([
        '../css/blog.css',
        '../css/blog-responsive.css',
        '../css/modules.css',
        '../css/modules-responsive.css',
        '../css/plugins.css',
        '../css/woocommerce.css',
        '../css/woocommerce-responsive.css',
        '../css/wpml.css'
    ])
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('../css'));
});

// Default Task
gulp.task('default', ['all', 'third_party', 'sass']);

// Minify Files
gulp.task('minify', ['all', 'third_party', 'sass', 'minifyjs', 'minifycss']);

// Watch Files For Changes
gulp.task('watch', function () {
    gulp.watch('../js/modules/*.js', ['all', 'third_party','minifyjs']);
    gulp.watch('../css/scss/**/*.scss', ['sass','minifycss']);
});
