import Ember from 'ember';

export default Ember.Controller.extend({
	isSaving: false,

	actions: {
		save(video) {
			this.set('isSaving', true);
			video.save().then((video) => {
				this.set('isSaving', false);
				this.transitionToRoute('skill.manage.videos', video.get('skill').get('slug'));
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
