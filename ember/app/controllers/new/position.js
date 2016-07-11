import Ember from 'ember';

export default Ember.Controller.extend({

	isSaving: false,

	actions: {
		save(position) {
			this.set('isSaving', true);

			position.save().then(() => {
				this.set('isSaving', false);
				this.transitionToRoute('index');
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
