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
        src: ['bower_components/jquery/dist/jquery.js',
              'bower_components/bootstrap/dist/js/bootstrap.js',
              'bower_components/AdminLTE/plugins/slimscroll/jquery.slimscroll.js',
              'bower_components/AdminLTE/dist/js/app.js',
              'bower_components/AdminLTE/plugins/select2/select2.full.js',
              'bower_components/AdminLTE/plugins/ionslider/ion.rangeSlider.min.js',
              'bower_components/datatables.net/js/jquery.dataTables.js',
              'bower_components/datatables.net-bs/js/dataTables.bootstrap.js',
              'bower_components/datatables.net-rowreorder/js/dataTables.rowReorder.js',
              'bower_components/datatables.net-select/js/dataTables.select.js',
              'bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js',
              'bower_components/jquery-locationpicker-plugin/dist/locationpicker.jquery.js',
              'bower_components/select2sortable/select2sortable.js',
              'bower_components/range2dslider/jquery.range2dslider.js',
              'bower_components/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all.js',
              'bower_components/json-editor/dist/jsoneditor.js',
              'bower_components/uploader/src/dmuploader.js',
              'bower_components/jquery-ui/jquery-ui.js',
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
          'bower_components/AdminLTE/bootstrap/fonts/*',
          'bower_components/font-awesome/fonts/*',
          'bower_components/roboto-fontface/fonts/Roboto-Regular.*',
          'bower_components/roboto-fontface/fonts/Roboto-RegularItalic.*',
          'bower_components/roboto-fontface/fonts/Roboto-Bold.*',
          'bower_components/roboto-fontface/fonts/Roboto-BoldItalic.*',
  		  ], 
  		  dest: 'public/assets/fonts'
  	  }
	  },
    cssmin: {
      options: {
        shorthandCompacting: false,
        roundingPrecision: -1,
        sourceMap: true,
        report: "min",
      },
      target: {
        files: {
          'public/assets/css/rf.min.css': [
            '.tmp/rf.css'
    		  ],
          'public/assets/css/assets.min.css': [
            'bower_components/datatables.net-bs/css/dataTables.bootstrap.css',
            'bower_components/datatables.net-select-bs/css/select.bootstrap.css',
            'bower_components/datatables.net-rowreorder-bs/css/rowReorder.bootstrap.css',
            'bower_components/AdminLTE/bootstrap/css/bootstrap.min.css',
            'bower_components/AdminLTE/plugins/iCheck/square/blue.css',
            'bower_components/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.css', 
            'bower_components/AdminLTE/plugins/select2/select2.min.css',
            'bower_components/AdminLTE/plugins/ionslider/ion.rangeSlider.css',
            'bower_components/AdminLTE/plugins/ionslider/ion.rangeSlider.skinNice.css',
            'bower_components/range2dslider/jquery.range2dslider.css',
            'bower_components/uploader/src/uploader.css'
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

