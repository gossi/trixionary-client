/*jshint node:true*/
/* global require, module */
var EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
	var app = new EmberApp(defaults, {
		// Add options here
	});

	// Use `app.import` to add additional libraries to the generated
	// output files.
	//
	// If you need to use different assets in different
	// environments, specify an object as the first parameter. That
	// object's keys should be the environment name and the values
	// should be the asset to use in that environment.
	//
	// If the library that you are including contains AMD or ES6
	// modules that you would like to import into your application
	// please specify an object with the list of modules as keys
	// along with the exports of each module as its value.

	// bootstrap
	if (app.env === 'development') {
		app.import('bower_components/bootstrap/dist/js/bootstrap.js');
		app.import('bower_components/bootstrap/dist/css/bootstrap-theme.css');
		app.import('bower_components/bootstrap/dist/css/bootstrap.css');
	}

	// vis.js
	app.import('bower_components/vis/dist/vis.js');
	app.import('bower_components/vis/dist/vis.css');

	// BigScreen
	app.import('bower_components/BigScreen/bigscreen.js');

	// jquery.upload
	app.import('bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js');
	app.import('bower_components/blueimp-file-upload/js/jquery.fileupload.js');
	app.import('bower_components/blueimp-file-upload/css/jquery.fileupload.css');

	// jquery-colorbox
	app.import('bower_components/jquery-colorbox/jquery.colorbox.js');
	app.import('bower_components/jquery-colorbox/example3/colorbox.css');
	app.import('bower_components/jquery-colorbox/example3/images/controls.png', {
		destDir: 'assets/images'
	});
	app.import('bower_components/jquery-colorbox/example3/images/loading.gif', {
		destDir: 'assets/images'
	});

	return app.toTree();
};
