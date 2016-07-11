import Ember from 'ember';

export default Ember.Component.extend({
	tagName: 'button',
	classNames: ['btn', 'btn-primary'],
	attributeBindings: ['disabled'],

	isSaving: false,
	disabled: Ember.computed('isSaving', function() {
		return this.get('isSaving') === true;
	})
});
