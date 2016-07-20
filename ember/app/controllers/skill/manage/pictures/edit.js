import Ember from 'ember';

export default Ember.Controller.extend({
	isSaving: false,

	actions: {
		save(picture) {
			this.set('isSaving', true);
			picture.save().then((picture) => {
				this.set('isSaving', false);
				this.transitionToRoute('skill.manage.pictures', picture.get('skill').get('slug'));
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
