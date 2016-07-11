import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model(params) {
		return this.store.findRecord('gossi.trixionary/video', params.id);
	}
});
