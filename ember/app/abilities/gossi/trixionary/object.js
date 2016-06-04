import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-delete');
	}),
	canReadSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-sport-relationship-read');
	}),
	canUpdateSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-sport-relationship-update');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-skill-relationship-update');
	}),
	canAddSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-skill-relationship-add');
	}),
	canRemoveSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'object-to-skill-relationship-remove');
	})
});
