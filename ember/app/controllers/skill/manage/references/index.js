import Ember from 'ember';

export default Ember.Controller.extend({
	skillController: Ember.inject.controller('skill'),

	skill: Ember.computed('skillController', function() {
		return this.get('skillController').get('model');
	}),

	markedDelete: null,

	close() {
		this.set('markedDelete', null);
	},

	actions: {
		delete(reference) {
			this.set('markedDelete', reference);
		},

		cancel() {
			this.close();
		},

		ok() {
			this.get('markedDelete').removeObject(this.get('skill'));
			this.get('markedDelete').save();
			this.close();
		},

		close() {
			this.close();
		}
	}
});
