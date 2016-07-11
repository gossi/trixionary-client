import Ember from 'ember';

export default Ember.Mixin.create({
	actions: {
		willTransition() {
			this._super(...arguments);
			const record = this.controller.get('model');
			record.rollbackAttributes();
		}
	}
});
