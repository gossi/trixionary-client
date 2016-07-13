import Ember from 'ember';

export default Ember.Route.extend({
	resetController(controller, isExiting, transition) {
    	if (isExiting) {
			controller.set('from', null);
			controller.set('to', null);
		}
	}
});
