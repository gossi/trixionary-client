import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	currentPath: Ember.computed('application.currentPath', function() {
		return this.get('application').get('currentPath');
	})
});
