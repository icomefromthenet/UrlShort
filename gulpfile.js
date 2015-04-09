// Include gulp
var gulp = require('gulp');

// Include plugins
var concat    = require('gulp-concat');
var minifyCSS = require('gulp-minify-css');
var rename    = require('gulp-rename');
var less      = require('gulp-less');
var uglify    = require('gulp-uglify');
var fs        = require('fs');
var watch     = require('gulp-watch');
var batch     = require('gulp-batch');
var plumber   = require('gulp-plumber');


var projectConfig   = {
     js : {
       src: 'resources/assets/script/'
       ,dest:'web/script'
       ,build: [
          'jquery.js'
         ,'mithril.js'
         ,'collections.min.js'
         ,'moment.js'
         ,'util.js'
         ,'urlshort.queue.common.model.js'
         ,'urlshort.queue.activity.model.js'
         ,'urlshort.queue.activity.view.js'
         ,'urlshort.queue.activity.controller.js'
         ]
     }
     ,css : {
       src :'resources/assets/css/'
      ,dest: 'web/css'
      ,build: [
        'pure.css'
        ,'side-menu.css'
      ]  
    }
    ,log : {
      dest : 'resources/log/'
    }
    ,cache : {
      dest : 'resources/cache/'
    }
};


// Concatenate JS Files
gulp.task('scripts', function() {
    var aFiles = [];
    var config = projectConfig.js;
    
    for (var file in config.build ) {
      aFiles.push(config.src+config.build[file]);
         
    }
    
    // check for bad path
    try {
      aFiles.forEach(fs.statSync);
    } catch (e) {
      console.log(e);
    }
    
    return gulp.src(aFiles)
      .pipe(plumber())
      .pipe(concat('app.js'))
      .pipe(gulp.dest(config.dest))
      .pipe(uglify())
      .pipe(rename('app.min.js'))
      .pipe(gulp.dest(config.dest));
      
});

gulp.task('css', function() {
    var aFiles = [];
    var config = projectConfig.css;
    
    for (var file in config.build ) {
      aFiles.push(config.src+config.build[file]);
    }
   
    // check for bad path
    try {
      aFiles.forEach(fs.statSync);
    } catch (e) {
      console.log(e);
    }
    
    
    return gulp.src(aFiles)
      .pipe(plumber())
      .pipe(concat('app.css'))
      .pipe(gulp.dest(config.dest))
      .pipe(minifyCSS())
      .pipe(rename('app.min.css'))
      .pipe(gulp.dest(config.dest));
      
});


gulp.task('watch_scripts', function () {
    
    var aFiles = [];
    var config = projectConfig.js;
    
    for (var file in config.build ) {
      aFiles.push(config.src+config.build[file]);
         
    }
    
    // check for bad path
    try {
      aFiles.forEach(fs.statSync);
    } catch (e) {
      console.log(e);
    }
    
    watch(aFiles, batch(function () {
        gulp.start('scripts');
    }));
});



// Default Task
gulp.task('default', ['scripts','css']);