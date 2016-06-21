import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		if (keeko && keeko.trixionary && keeko.trixionary.sportId) {
			return this.store.findRecord('gossi.trixionary/sport', keeko.trixionary.sportId, {
				'include': 'groups,objects,positions,skills,skills.parents,skills.lineages,skills.lineages.ancestor,skills.lineages.skill'
			}).then((response) => {
				return response;
			}, () => {
				return null;
			});
		} else {
			return null;
		}
	},

	actions: {
		reload() {
			this.refresh();
		}
	}
});
