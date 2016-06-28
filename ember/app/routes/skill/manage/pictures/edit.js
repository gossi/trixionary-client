import Ember from 'ember';

export default Ember.Route.extend({
	model(params) {
		return this.store.findRecord('gossi.trixionary/picture', params.id);
	},

	actions: {
		save(picture) {
			picture.save().then((picture) => {
				this.transitionTo('skill.manage.pictures', picture.get('skill').get('slug'));
			})
		}
	}
});
