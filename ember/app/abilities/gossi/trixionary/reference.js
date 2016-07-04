import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-delete');
	}),
	canReadVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-video-relationship-read');
	}),
	canUpdateVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-video-relationship-update');
	}),
	canAddVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-video-relationship-add');
	}),
	canRemoveVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-video-relationship-remove');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-skill-relationship-update');
	}),
	canAddSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-skill-relationship-add');
	}),
	canRemoveSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'reference-to-skill-relationship-remove');
	})
});
