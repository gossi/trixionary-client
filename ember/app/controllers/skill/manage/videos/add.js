import Ember from 'ember';

export default Ember.Controller.extend({
	skillController: Ember.inject.controller('skill'),

	isSaving: false,

	doSave(video) {
		this.set('isSaving', true);
		video.save({
			adapterOptions: {
				meta: {
					filename: video.get('filename')
				}
			}
		}).then((video) => {
			this.set('isSaving', false);
			this.transitionToRoute('skill.videos', video.get('skill').get('slug'));
		}).catch(() => {
			this.set('isSaving', false);
		});
	},

	actions: {
		save (video) {
			let reference = this.get('reference');
			if (reference.get('url')) {
				let skill = this.get('skillController').get('model');
				reference.set('type', 'multimedia');
				reference.save().then((reference) => {
					reference.get('skills').pushObject(skill);
					reference.save();
					this.doSave(video);
				});
			} else {
				this.doSave(video);
			}
		}
	}
});
