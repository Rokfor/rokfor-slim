module.exports = function(grunt) {
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    less: {
      // Development not compressed
      development: {
        options: {
          compress: false
        },
        files: {
          ".tmp/rf.css": "build/less/rf.less",
        }
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        sourceMap: true
      },
      build: {
        src: ['vendor/almasaeed2010/adminlte/plugins/jQuery/jQuery-2.1.4.min.js',
              'vendor/almasaeed2010/adminlte/dist/js/app.js',
              'vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.js',
              'vendor/almasaeed2010/adminlte/plugins/slimscroll/jquery.slimscroll.js',
              'build/js/DataTables/DataTables-1.10.10/js/jquery.dataTables.js',
              'build/js/DataTables/DataTables-1.10.10/js/dataTables.bootstrap.js',
              'build/js/DataTables/RowReorder-1.1.0/js/dataTables.rowReorder.js',
              'build/js/DataTables/Select-1.1.0/js/dataTables.select.js',
              'vendor/almasaeed2010/adminlte/plugins/select2/select2.full.js',
        
              'vendor/robinherbots/jquery.inputmask/dist/jquery.inputmask.bundle.js',
        
              'vendor/almasaeed2010/adminlte/plugins/ionslider/ion.rangeSlider.min.js',
              'vendor/logicify/jquery-locationpicker-plugin/dist/locationpicker.jquery.js',
              'vendor/urshofer/select2sortable/select2sortable.js',
              'vendor/xdan/range2dslider/jquery.range2dslider.js',
              'vendor/summernote/summernote/dist/summernote.js',
              'vendor/jdorn/json-edit/dist/jsoneditor.js',
              'vendor/danielm/uploader/src/dmuploader.js',
              'build/js/jquery-ui/jquery-ui.js',
              'build/js/*.js'],
        dest: 'public/assets/js/rf.min.js'
      }
    },
    copy: {
  	  images: {
  		  expand: true,
        flatten: true,
  		  src: [
          'build/img/*'
  		  ], 
  		  dest: 'public/assets/img'
  	  },
  	  fonts: {
  		  expand: true,
        flatten: true,
  		  src: [
          'build/font/*',
          'vendor/almasaeed2010/adminlte/bootstrap/fonts/*',
          'vendor/fortawesome/font-awesome/fonts/*'
  		  ], 
  		  dest: 'public/assets/fonts'
  	  }
	  },
    cssmin: {
      options: {
        shorthandCompacting: false,
        roundingPrecision: -1,
        sourceMap: true,
        report: "min"
      },
      target: {
        files: {
          'public/assets/css/rf.min.css': [
            'build/js/DataTables/datatables.min.css',
            'vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css',
            'vendor/almasaeed2010/adminlte/plugins/iCheck/square/blue.css',
            'vendor/summernote/summernote/dist/summernote.css',
            'vendor/almasaeed2010/adminlte/plugins/select2/select2.min.css',
            'vendor/almasaeed2010/adminlte/plugins/ionslider/ion.rangeSlider.css',
            'vendor/almasaeed2010/adminlte/plugins/ionslider/ion.rangeSlider.skinNice.css',
            'vendor/xdan/range2dslider/jquery.range2dslider.css',
            'vendor/danielm/uploader/src/uploader.css',
            '.tmp/rf.css'
    		  ]
        }
      }
    },
    watch: {
      scripts: {
        files: ['build/js/**'],
        tasks: ['uglify'],
        options: {
  	      event: ['deleted','changed'],	// Compatible with Transmit Upload
  		    livereload: true,
  	    }
      },
      css: {
        files: ['build/less/**'],
        tasks: ['less', 'copy', 'cssmin'],
        options: {
  	      event: ['deleted','changed'],	// Compatible with Transmit Upload
  		    livereload: true,
  	    }
      }
    }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-copy');  
  grunt.loadNpmTasks('grunt-contrib-less');  
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  
  // Default task(s).
  grunt.registerTask('default', ['uglify', 'less', 'copy', 'cssmin']);

};

