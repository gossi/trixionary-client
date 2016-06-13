import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.query('gossi.trixionary/object', {
			filter: {
				'slug': params.object
			},
			include: 'skills,skills.variationOf,skills.variations,skills.multiples,sport',
		}).then((objects) => {
			return objects.get('firstObject');
		});
	}
});
