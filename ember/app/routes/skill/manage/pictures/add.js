import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model() {
		let skill = this.modelFor('skill');
		let picture = this.store.createRecord('gossi.trixionary/picture');
		picture.set('skill', skill);

		return picture;
	}
});
