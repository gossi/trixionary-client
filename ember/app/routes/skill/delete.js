import Ember from 'ember';

export default Ember.Route.extend({
	actions: {
		delete() {
			let skill = this.modelFor(this.routeName);
			skill.destroyRecord().then(() => {
				this.transitionTo('index');
			});
		}
	}
});
