'use strict';

var DEV_FOLDER = 'source',
    DEST_FOLDER = 'assets';
module.exports = function(grunt) {
    require('time-grunt')(grunt);
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
			dist: {
				options: {
					separator: ';'
				},
				src: [
					'<%= dev %>/javascript/js/vendor/*.js'
				],
				dest: '<%= dest %>/js/src/vendor/lib.js'
			}
		},
        modernizr: {
		  build: {
		    devFile: '<%= dev %>/javascript/modernizr/modernizr.js',
		    dest: '<%= dev %>/javascript/js/vendor/1.modernizr.min.js',
		    files: {
		      'src': [
		        ['<%= dest %>/js/src/scripts.js'],
		        ['<%= dest %>/css/main.css']
		      ]
		    },
			options : [
                "setClasses",
                "addTest",
                "html5printshiv",
                "testProp",
                "fnBind",
                "prefixed",
                "testAllProps",
                "hasEvent",
                "mq"
            ],
		    uglify: false,
		    crawl: true
		  }
		},
        uglify: {
			options: {
				mangle: true,
				compress: {
					warnings: false,
					screw_ie8: true
				},
				preserveComments: false,
			},
			js: {
				files: [{
					expand: true,
					cwd: '<%= dest %>/js/src',
					src: '**/*.js',
					dest: '<%= dest %>/js/bundle',
					ext: '.min.js'
				}]
			}
		},
		browserify: {
			dist: {
				files: {
					'<%= dest %>/js/src/scripts.js' : ['<%= dev %>/coffee/app.coffee']
				},
				options: {
					transform: ['coffeeify']
				}
			}
		},
		compass: {
            dest: {
				options: {
					outputStyle : 'compress',
					sassDir: '<%= dev %>/sass', // css_dir = 'dev/css'
					cssDir: '<%= dest %>/css'
				}
			}
		},
        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer')({browsers: ['> 1%', 'ff > 3', 'ie >= 8']}),
                    require('postcss-flexibility')()
                ]
            },
            dist: {
                src: '<%= dest %>/css/main.css',
                dest: '<%= dest %>/css/main.css'
            }
        },
		pug: {
			bundle: {
				options: {
					pretty: false
				},
				files: [
                    {
						expand: true,
						cwd: '<%= dev %>/jade',
						src: ['*.jade'],
						dest: '<%= dest %>/tpl',
						ext: '.tpl.html'
				    }
                ]
			}
		},
        ngtemplates : {
            app: {
                options : {
                    module : 'castadiva',
                    bootstrap: function(module, script) {
                        return 'module.exports = function($templateCache) {' + script + ';}';
                    },
                    prefix: "' + assetsPath + 'tpl/"
                },
                src:  [ '<%= dest %>/tpl/*.tpl.html'],
                dest: '<%= dev %>/coffee/angular/models/templates.js'
            }
        },
        tinypng: {
            options: {
                apiKey: "d3cCkETrqGcKnv2uEyWrnb5Qb_1rsghT"
            },
            compress: {
                expand: true, 
                src: '<%= dest %>/img/*.{png,jpg}', 
                dest: '<%= dest %>/img/'
            }
        },
        watch: {
            configFiles: {
                files: [ 'Gruntfile.js'],
                options: {
                    reload: true
                }
            },
            compass: {
                files: ['<%= dev %>/sass/**/*.scss'],
                tasks: ['compass']
            },
            pug: {
                files: ['<%= dev %>/jade/*.jade','<%= dev %>/jade/inc/svg/*.svg'],
                tasks: ['newer:pug']
            },
            templates: {
                files: ['<%= dest %>/tpl/*.tpl.html'],
                tasks: ['newer:ngtemplates']
            },
            js: {
                files: ['<%= dev %>/javascript/**/*.js','<%= dev %>/coffee/**/**/*.coffee','<%= dev %>/coffee/**/**/*.js'],
                tasks: ['scripts']
            },
            postcss: {
                files: ['<%= dest %>/css/main.css'],
                tasks: ['postcss', 'modernizr']
            }
        },
        dev : DEV_FOLDER,
        dest: DEST_FOLDER
    });
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-pug');
    grunt.loadNpmTasks('grunt-modernizr');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-tinypng');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-newer');
    grunt.registerTask('scripts', ['browserify','newer:concat','newer:uglify']);
    grunt.registerTask('default', ['jade', 'compass', 'autoprefixer', 'modernizr', 'scripts']);
    grunt.registerTask('load', ['watch']);
    grunt.registerTask('kill', function() {
        process.exit(1);
    });   
}