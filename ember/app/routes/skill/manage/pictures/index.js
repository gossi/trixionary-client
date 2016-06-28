import Ember from 'ember';

export default Ember.Route.extend({
	actions: {
		setFeatured(picture) {
			let skill = this.get('model');
			skill.set('featuredPicture', picture);
			skill.save();
		}
	}
});
