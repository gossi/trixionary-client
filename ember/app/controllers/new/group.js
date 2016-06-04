import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	sport: Ember.computed('application', function() {
		return this.get('application').get('model');
	}),

	actions: {
		save(group) {
			group.set('sport', this.get('sport'));
			group.save().then(() => {
				this.transitionToRoute('index');
			});
		}
	}
});
