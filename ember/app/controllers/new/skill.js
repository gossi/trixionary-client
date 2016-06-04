import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	sport: Ember.computed('application', function() {
		return this.get('application').get('model');
	}),

	actions: {
		save(skill) {
			skill.set('sport', this.get('sport'));
			skill.save().then(() => {
				// transition to skill
			});
		}
	}
});
