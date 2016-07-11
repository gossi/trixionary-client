import Ember from 'ember';
import RollbackRoute from 'trixionary/mixins/rollback-route';

export default Ember.Route.extend(RollbackRoute, {
	reference: null,

	model() {
		let skill = this.modelFor('skill');
		let video = this.store.createRecord('gossi.trixionary/video');
		let reference = this.store.createRecord('gossi.trixionary/reference');
		video.set('reference', reference);
		video.set('skill', skill);
		this.set('reference', reference);

		return video;
	},

	setupController: function(controller, model) {
    	this._super(controller, model);
		controller.set('reference', this.get('reference'));
  	}
});
