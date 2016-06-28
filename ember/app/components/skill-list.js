import Ember from 'ember';

export default Ember.Component.extend({
	tagName: 'ul',
	classNames: ['media-list', 'skill-list'],

	sortBy: 'name'
});
