import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.query('gossi.trixionary/skill', {
			filter: {
				slug: params.skill
			},
			include: "start-position,end-position,groups,object,sport,parents,children,parts,composites,multiples,multiple-of,variations,variation-of,lineages"
		}).then((skills) => {
			return skills.get('firstObject');
		});
	}
});
