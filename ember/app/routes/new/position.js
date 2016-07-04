import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let sport = this.modelFor('application');
		let position = this.store.createRecord('gossi.trixionary/position');
		position.set('sport', sport);

		return position;
	},

	actions: {
		save(position) {
			position.save().then(() => {
				this.transitionTo('index');
			});
		}
	}
});
