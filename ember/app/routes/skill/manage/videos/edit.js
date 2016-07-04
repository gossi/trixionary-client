import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.findRecord('gossi.trixionary/video', params.id);
	},

	actions: {
		save(video) {
			video.save().then((video) => {
				this.transitionTo('skill.manage.videos', video.get('skill').get('slug'));
			})
		}
	}
});
