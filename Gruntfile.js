'use strict';

module.exports = function(grunt)
{

    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-copy");
    grunt.loadNpmTasks("grunt-mkdir");

    grunt.initConfig({
        pgk: grunt.file.readJSON("package.json"),

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
                        src: ["js/**", "libs/**","html/**", "fonts/**", "img/**","php/**", "index.html"],
                        dest: "www"
                    }

                ]
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
                    'src/html/**',
                    'src/js/**',
                    'src/php/**'
                ],
                tasks:['copy:for_www']
            }
        }

    });

    grunt.registerTask("default", ["less", "copy:for_www", "mkdir", "watch"]);
    grunt.registerTask("run", ["less", "copy:for_www", "mkdir", "watch"]);

};