import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model() {
		return this.store.createRecord('gossi.trixionary/reference');
	}
});
