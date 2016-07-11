import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model() {
		let sport = this.modelFor('application');
		let group = this.store.createRecord('gossi.trixionary/group');
		group.set('sport', sport);

		return group;
	}
});
