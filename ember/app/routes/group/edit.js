import Ember from 'ember';

export default Ember.Route.extend({
	save(group) {
		group.save().then(() => {
			this.transitionTo('group', group.get('slug'));
		}, () => {
			console.log('something went wrong');
		});
	}
});
