import Ember from 'ember';
import config from 'trixionary/config/environment';

export default Ember.Route.extend({
	model() {
		if (config.keeko && config.keeko.trixionary && config.keeko.trixionary.sportId) {
			return this.store.findRecord('gossi.trixionary/sport', config.keeko.trixionary.sportId, {
				'include': 'groups,objects,positions,skills,skills.groups,skills.objects,skills.start-position,skills.end-position,skills.variationOf,skills.parents,skills.lineages,skills.lineages.ancestor,skills.lineages.skill,skills.featured-picture'
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
