import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		let sport = this.modelFor('application');
		let objects = sport.get('objects');
		return objects.filterBy('slug', params.object)[0];
		// return this.store.query('gossi.trixionary/object', {
		// 	filter: {
		// 		fields: {
		// 			slug: params.object
		// 		}
		// 	},
		// 	include: 'skills,skills.variationOf,skills.variations,skills.multiples,sport',
		// }).then((objects) => {
		// 	return objects.get('firstObject');
		// });
	}
});
