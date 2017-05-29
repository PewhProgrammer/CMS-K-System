'use strict';

module.exports = function(grunt)
{

    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-copy");

    grunt.initConfig({
        pgk: grunt.file.readJSON("package.json"),

        sass: {
            options: {
                sourceMap: true
            },
            dist: {
                files: {
                    'www/main.css': 'src/sass/main.scss'
                }
            }
        },
        copy: {
            for_www: {
                files: [
                    {
                        expand: true,
                        cwd: "src/",
                        src: ["js/**", "libs/**","pages/**", "index.html"],
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
            sass: {
                files: [
                    'src/sass/**',
                    '!src/sass/*.map'
                ],
                tasks: ['sass']
            },
            others: {
                files: [
                    'src/index.html'
                ],
                tasks:['copy:for_www']
            }
        }

    });

    grunt.registerTask("default", ["sass", "copy:for_www", "watch"]);
    grunt.registerTask("run", ["sass", "copy:for_www", "watch"]);

};