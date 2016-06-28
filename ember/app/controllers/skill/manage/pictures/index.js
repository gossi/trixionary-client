import Ember from 'ember';

export default Ember.Controller.extend({
	markedDelete: null,

	close() {
		this.set('markedDelete', null);
	},

	actions: {
		delete(picture) {
			this.set('markedDelete', picture);
		},

		cancel() {
			this.close();
		},

		ok() {
			this.get('markedDelete').destroyRecord();
			this.close();
		},

		close() {
			this.close();
		}
	}
});
