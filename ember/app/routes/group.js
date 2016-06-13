import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.query('gossi.trixionary/group', {
			filter: {
				'slug': params.group
			},
			include: 'skills,skills.variationOf,skills.variations,skills.multiples,sport',
		}).then((groups) => {
			return groups.get('firstObject');
		});
	}
});
