import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		let sport = this.modelFor('application');
		let groups = sport.get('groups');
		return groups.filterBy('slug', params.group)[0];
		// return this.store.query('gossi.trixionary/group', {
		// 	filter: {
		// 		fields: {
		// 			slug: params.group
		// 		}
		// 	},
		// 	include: 'skills,skills.variationOf,skills.variations,skills.multiples,sport',
		// }).then((groups) => {
		// 	return groups.get('firstObject');
		// });
	}
});
