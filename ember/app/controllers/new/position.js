import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	sport: Ember.computed('application', function() {
		return this.get('application').get('model');
	}),

	actions: {
		save(position) {
			position.set('sport', this.get('sport'));
			position.save().then(() => {
				this.transitionToRoute('index');
			});
		}
	}
});
