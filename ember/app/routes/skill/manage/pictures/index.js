import Ember from 'ember';

export default Ember.Route.extend({
	actions: {
		setFeatured(picture) {
			let skill = this.modelFor('skill');
			skill.set('featuredPicture', picture);
			skill.save();
		}
	}
});
