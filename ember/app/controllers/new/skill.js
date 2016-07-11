import Ember from 'ember';

export default Ember.Controller.extend({

	isSaving: false,

	actions: {
		save(skill) {
			this.set('isSaving', true);
			skill.save({
				adapterOptions: {
					meta: {
						filename: skill.get('filename')
					}
				}
			}).then((skill) => {
				this.set('isSaving', false);
				this.transitionToRoute('skill', skill.get('slug'));
			}).catch(() => {
				this.set('isSaving', false);
			});
		}
	}
});
