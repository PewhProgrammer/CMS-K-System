'use strict';

module.exports = function(grunt)
{

    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-copy");

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
                    'src/index.html'
                ],
                tasks:['copy:for_www']
            }
        }

    });

    grunt.registerTask("default", ["less", "copy:for_www", "watch"]);
    grunt.registerTask("run", ["less", "copy:for_www", "watch"]);

};