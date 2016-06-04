import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-delete');
	}),
	canReadObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-object-relationship-read');
	}),
	canUpdateObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-object-relationship-update');
	}),
	canAddObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-object-relationship-add');
	}),
	canRemoveObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-object-relationship-remove');
	}),
	canReadPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-position-relationship-read');
	}),
	canUpdatePosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-position-relationship-update');
	}),
	canAddPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-position-relationship-add');
	}),
	canRemovePosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-position-relationship-remove');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-skill-relationship-update');
	}),
	canAddSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-skill-relationship-add');
	}),
	canRemoveSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-skill-relationship-remove');
	}),
	canReadGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-group-relationship-read');
	}),
	canUpdateGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-group-relationship-update');
	}),
	canAddGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-group-relationship-add');
	}),
	canRemoveGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'sport-to-group-relationship-remove');
	})
});
