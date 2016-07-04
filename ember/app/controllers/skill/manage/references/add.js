import Ember from 'ember';

export default Ember.Controller.extend({
	skillController: Ember.inject.controller('skill'),

	skill: Ember.computed('skillController', function() {
		return this.get('skillController').get('model');
	}),

	actions: {
		save(reference) {
			let skill = this.get('skill');
			reference.get('skills').pushObject(skill);
			reference.save().then(() => {
				this.transitionToRoute('skill.manage.references', skill.get('slug'));
			});
		}
	}
});
