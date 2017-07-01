var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
//var imagemin = require('gulp-imagemin');
   
//styles task
gulp.task('styles', function(){
   gulp.src('./assets/scss/main.scss')
       .pipe(sass())
       .pipe(gulp.dest('./assets/css'))
       .pipe(browserSync.reload({stream:true}));
});


//image task
//compress
// gulp.task('image', function(){
//    gulp.src('.../uploads/2017/**/*.{jpg,JPG,png}')
//        .pipe(imagemin())
//        .pipe(gulp.dest('.../uploads/test'))
// });
  

//browserSync task
gulp.task('serve', function(){

	browserSync.init({ 
		open: 'external',
		proxy: 'http://localhost:8888/widget_corp/public/admin.php',
		port: 8080
	});
   
	     
   
//gulp.watch('.../uploads/**/*.{jpg,JPG,png}',['image']);
gulp.watch('./**/*').on('change', browserSync.reload);


});   


gulp.task('default', ['serve']);
