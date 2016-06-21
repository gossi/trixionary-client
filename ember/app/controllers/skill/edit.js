import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	actions: {
		save(skill) {
			skill.save().then(() => {
				this.get('application').send('reload');
				this.transitionToRoute('skill', skill.get('slug'));
			}, (failure) => {
				console.log('something went wrong');
				console.log(failure);
			});
		}
	}
});
