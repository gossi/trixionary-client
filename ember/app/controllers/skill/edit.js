import Ember from 'ember';

export default Ember.Controller.extend({
	actions: {
		save(skill) {
			skill.save().then(() => {
				this.transitionToRoute('skill', skill.get('slug'));
			}, (failure) => {
				console.log('something went wrong');
				console.log(failure);
			});
		}
	}
});
