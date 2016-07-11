import Ember from 'ember';

export default Ember.Controller.extend({
	skillController: Ember.inject.controller('skill'),

	skill: Ember.computed('skillController', function() {
		return this.get('skillController').get('model');
	}),

	isSaving: false,

	actions: {
		save(reference) {
			this.set('isSaving', true);
			let skill = this.get('skill');
			reference.get('skills').pushObject(skill);
			reference.save().then(() => {
				this.set('isSaving', false);
				this.transitionToRoute('skill.manage.references', skill.get('slug'));
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
