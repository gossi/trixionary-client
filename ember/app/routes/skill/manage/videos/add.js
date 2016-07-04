import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let skill = this.modelFor('skill');
		let video = this.store.createRecord('gossi.trixionary/video');
		let reference = this.store.createRecord('gossi.trixionary/reference');
		video.set('reference', reference);
		video.set('skill', skill);

		return video;
	},

	doSave(video) {
		video.save({
			adapterOptions: {
				meta: {
					filename: video.get('filename')
				}
			}
		}).then((video) => {
			this.transitionTo('skill.videos', video.get('skill').get('slug'));
		});
	},

	actions: {
		save (video) {
			let reference = video.get('reference');
			if (reference.get('url')) {
				let skill = this.modelFor('skill');
				reference.save().then((reference) => {
					reference.get('skills').pushObject(skill);
					reference.save();
					doSave(video);
				});
			} else {
				doSave(video);
			}
		}
	}
});
