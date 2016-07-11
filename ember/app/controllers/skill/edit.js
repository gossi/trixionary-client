import Ember from 'ember';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),

	isSaving: false,

	actions: {
		save(skill) {
			this.set('isSaving', true);
			skill.save({
				adapterOptions: {
					meta: {
						filename: skill.get('filename'),
						sequence_delete: skill.get('sequence_delete')
					}
				}
			}).then(() => {
				this.set('isSaving', false);
				this.get('application').send('reload');
				this.transitionToRoute('skill', skill.get('slug'));
			}, (failure) => {
				this.set('isSaving', false);
				console.log('something went wrong');
				console.log(failure);
			});
		}
	}
});
