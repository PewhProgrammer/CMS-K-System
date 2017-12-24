'use strict';

module.exports = function(grunt)
{

    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-copy");
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks("grunt-mkdir");

    grunt.initConfig({
        pgk: grunt.file.readJSON("package.json"),
        clean: {
            build: {
                src: ['www']
            }
        },
        less: {
            options: {
                sourceMap: true
            },
            dist: {
                files: {
                    'www/main.css': 'src/less/main.less'
                }
            }
        },
        copy: {
            for_www: {
                files: [
                    {
                        expand: true,
                        cwd: "src/",
                        src: ["js/main.js", "libs/**","admin/**", "fonts/**", "img/**","php/**", "index.php"],
                        dest: "www"
                    }

                ]
            }
        },
        uglify: {
            options: {
                sourceMapIncludeSources: true
            },
            development: {
                options: {
                    mangle: false,
                    sourceMap: true,
                    compress: false
                },
                files: {
                    'www/js/modules.min.js': ['src/js/modules/*.js']
                }
            }
        },
        mkdir: {
            all: {
                options: {
                    create: ['www/uploads']
                }
            }
        },
        watch: {
            options: {
                spawn: false,
                livereload: true
            },
            less: {
                files: [
                    'src/less/**',
                    '!src/less/*.map'
                ],
                tasks: ['less']
            },
            others: {
                files: [
                    'src/index.php',
                    'src/admin/**',
                    'src/js/**',
                    'src/php/**'
                ],
                tasks:['copy:for_www', "uglify"]
            }
        }

    });

    grunt.registerTask("default", ["clean", "less", "copy:for_www", "mkdir", "uglify:development", "watch"]);
    grunt.registerTask("run", ["clean", "less", "copy:for_www", "mkdir", "uglify:development", "watch"]);

};