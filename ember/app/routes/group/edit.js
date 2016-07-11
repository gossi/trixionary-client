import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	save(group) {
		group.save().then(() => {
			this.transitionTo('group', group.get('slug'));
		}, () => {
			console.log('something went wrong');
		});
	}
});
