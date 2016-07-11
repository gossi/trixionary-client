import Ember from 'ember';

export default Ember.Component.extend({
	classNames: ['trixionary-picture'],

	didInsertElement() {
		this._super(...arguments);
		this.$("a[href]").colorbox({
			rel: 'gallery',
			maxHeight: '95%'
		});
	}
});
