import Ember from 'ember';

export default Ember.Controller.extend({
	skillController: Ember.inject.controller('skill'),

	isSaving: false,

	actions: {
		save(picture) {
			this.set('isSaving', true);
			picture.save({
				adapterOptions: {
					meta: {
						filename: picture.get('filename')
					}
				}
			}).then((picture) => {
				this.set('isSaving', false);
				let skill = this.get('skillController').get('model');
				if (skill.get('pictures').get('length') === 1) {
					skill.set('featuredPicture', picture);
					skill.save();
				}
				this.transitionToRoute('skill.pictures', picture.get('skill').get('slug'));
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
