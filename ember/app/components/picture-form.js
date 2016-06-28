import Ember from 'ember';

export default Ember.Component.extend({

	actions: {
		save() {
			this.sendAction('save', this.get('picture'));
		},

		uploaded(data) {
			this.get('picture').set('filename', data.filename);
		},

		deleted() {
			this.get('picture').set('filename', null);
		}
	}
});
