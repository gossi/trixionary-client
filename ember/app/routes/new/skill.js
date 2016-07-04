import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let sport = this.modelFor('application');
		let skill = this.store.createRecord('gossi.trixionary/skill');
		skill.set('sport', sport);

		if (sport.get('objects').get('length') === 1) {
			skill.set('object', sport.get('objects').objectAt(0));
		}
		return skill;
	},

	actions: {
		save(skill) {
			skill.save({
				adapterOptions: {
					meta: {
						filename: skill.get('filename')
					}
				}
			}).then((skill) => {
				this.transitionTo('skill', skill.get('slug'));
			});
		}
	}
});
