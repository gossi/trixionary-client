import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		let skill = this.modelFor('skill');
		let picture = this.store.createRecord('gossi.trixionary/picture');
		picture.set('skill', skill);

		return picture;
	},

	actions: {
		save(picture) {
			picture.save({
				adapterOptions: {
					meta: {
						filename: picture.get('filename')
					}
				}
			}).then((picture) => {
				let skill = this.modelFor('skill');
				if (skill.get('pictures').get('length') === 1) {
					skill.set('featuredPicture', picture);
					skill.save();
				}
				this.transitionTo('skill.pictures', picture.get('skill').get('slug'));
			});
		}
	}
});
