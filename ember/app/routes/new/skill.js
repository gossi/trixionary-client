import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	model() {
		let sport = this.modelFor('application');
		let skill = this.store.createRecord('gossi.trixionary/skill');
		skill.set('sport', sport);

		if (sport.get('objects').get('length') === 1) {
			skill.set('object', sport.get('objects').objectAt(0));
		}
		return skill;
	}
});
