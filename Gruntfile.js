/**
 * Grunt tasks
 */
module.exports = function(grunt) {
	
	// Project configuration.
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		uglify: {
			options: {
				preserveComments: 'some'
			},
			 my_target: {
				files: {
					'js/dist/jquery.repeatable.item.min.js': 'js/src/jquery.repeatable.item.js',
				}
			}
		},
		cssmin: {
			minify: {
				expand: true,
				cwd: 'css/',
				src: [ '*.css', '!*.min.css' ],
				dest: 'css/',
				ext: '.min.css'
			}
		},
		watch: {
			files: [ 'css/*', 'js/src/*' ],
			tasks: [ 'uglify', 'cssmin' ]
		}
	} );

	// Load plugins
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	// Default task(s).
	grunt.registerTask( 'default', [ 'watch' ] );
};