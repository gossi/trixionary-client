import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model() {
		let sport = this.modelFor('application');
		let position = this.store.createRecord('gossi.trixionary/position');
		position.set('sport', sport);

		return position;
	}
});
