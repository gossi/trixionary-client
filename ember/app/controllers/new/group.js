import Ember from 'ember';

export default Ember.Controller.extend({

	isSaving: false,

	actions: {
		save(group) {
			this.set('isSaving', true);

			group.save().then(() => {
				this.set('isSaving', false);
				this.transitionToRoute('index');
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
