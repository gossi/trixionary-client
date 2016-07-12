import Ember from 'ember';

export default Ember.Component.extend({
	classNames: ['skill-gallery', 'skill-gallery-pictures', 'clearfix'],
	classNameBindings: ['isTiles:skill-gallery-tiles', 'isDetails:skill-gallery-details'],

	toolbar: true,
	view: 'tiles',

	isTiles: Ember.computed('view', function() {
		return this.get('view') === 'tiles';
	}),

	isDetails: Ember.computed('view', function() {
		return this.get('view') === 'details';
	}),

	didInsertElement() {
		this._super(...arguments);
		this.$(".pictures").colorbox({
			rel: 'gallery',
			maxHeight: '95%'
		});
	},

	actions: {
		changeView(view) {
			this.set('view', view);
		}
	}
});
