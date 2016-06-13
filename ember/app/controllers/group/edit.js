import Ember from 'ember';

export default Ember.Controller.extend({
	actions: {
		save(group) {
			group.save().then(() => {
				this.transitionToRoute('group', group.get('slug'));
			}, () => {
				console.log('something went wrong');
			});
		}
	}
});
