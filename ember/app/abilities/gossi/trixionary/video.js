import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-delete');
	}),
	canReadFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_skill-relationship-read');
	}),
	canUpdateFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_skill-relationship-update');
	}),
	canAddFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_skill-relationship-add');
	}),
	canRemoveFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_skill-relationship-remove');
	}),
	canReadFeaturedTutorialSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_tutorial_skill-relationship-read');
	}),
	canUpdateFeaturedTutorialSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_tutorial_skill-relationship-update');
	}),
	canAddFeaturedTutorialSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_tutorial_skill-relationship-add');
	}),
	canRemoveFeaturedTutorialSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-featured_tutorial_skill-relationship-remove');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-skill-relationship-update');
	}),
	canReadReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-reference-relationship-read');
	}),
	canUpdateReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'video-to-reference-relationship-update');
	})
});
