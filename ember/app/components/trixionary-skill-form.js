import Ember from 'ember';

export default Ember.Component.extend({
	i18n: Ember.inject.service(),

	types: Ember.computed(function () {
		return [
			{
				key: 'skill',
				title: this.get('sport').get('skillLabel')
			},
			{
				key: 'composite',
				title: this.get('i18n').t('composite'),
				help: this.get('i18n').t('composite.explanation', {skills: this.get('sport').get('skillPluralLabel')}),
			},
			{
				key: 'multiple',
				title: this.get('i18n').t('multiple'),
				help: this.get('i18n').t('multiple.explanation')
			}
		];
	}),

	type: Ember.computed('types', function() {
		return this.get('types')[0];
	}),

	isSkill: Ember.computed('type', function() {
		return this.get('type').key === 'skill';
	}),
	isMultiple: Ember.computed('type', function() {
		return this.get('type').key === 'multiple';
	}),
	isComposite: Ember.computed('type', function() {
		return this.get('type').key === 'composite';
	}),

	actions: {
		save() {
			this.sendAction('save', this.get('skill'));
		},

		changeGroup(selection) {
			this.get('skill').set('groups', selection);
		},

		handleKeydown(dropdown, e) {
			// prevent submitting the form
			if (e.keyCode === 13) {
				e.preventDefault();
			}
	  	}
	},

	searchGroups(group, term) {
		return group.get('title').toLowerCase().indexOf(term.toLowerCase());
	}
});
