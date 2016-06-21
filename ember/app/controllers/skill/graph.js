import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	skills: Ember.computed('application.model.skills', function() {
		return this.get('application').get('model').get('skills');
	})
});
