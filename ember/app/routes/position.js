import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		let sport = this.modelFor('application');
		let positions = sport.get('positions');
		return positions.filterBy('slug', params.position)[0];
	}
});
