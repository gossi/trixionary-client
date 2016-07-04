import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let sport = this.modelFor('application');
		let group = this.store.createRecord('gossi.trixionary/group');
		group.set('sport', sport);

		return group;
	},

	actions: {
		save(group) {
			group.save().then(() => {
				this.transitionTo('index');
			});
		}
	}
});
