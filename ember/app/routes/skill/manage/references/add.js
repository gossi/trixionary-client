import Ember from 'ember';

export default Ember.Route.extend({
	model() {
		return this.store.createRecord('gossi.trixionary/reference');
	}
});
