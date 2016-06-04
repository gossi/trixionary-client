import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let sport = this.modelFor('application');
		let skill = this.store.createRecord('gossi.trixionary/skill');

		if (sport.get('objects').get('length') === 1) {
			skill.set('object', sport.get('objects').objectAt(0));
		}
		return skill;
	}
});
