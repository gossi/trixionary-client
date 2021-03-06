import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.query('gossi.trixionary/skill', {
			filter: {
				fields: {
					slug: params.skill
				}
			},
			include: "sport,groups,object,start-position,end-position,parents,children,parts,composites,multiples,multiple-of,variations,variation-of,lineages,featured-picture,featured-video,featured-tutorial,pictures,videos,references"
		}).then((skills) => {
			return skills.get('firstObject');
		});
	}
});
