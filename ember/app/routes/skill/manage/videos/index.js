import Ember from 'ember';

export default Ember.Route.extend({
	actions: {
		setFeaturedVideo(video) {
			let skill = this.modelFor('skill');
			skill.set('featuredVideo', video);
			skill.save();
		},

		setFeaturedTutorial(video) {
			let skill = this.modelFor('skill');
			skill.set('featuredTutorial', video);
			skill.save();
		}
	}
});
