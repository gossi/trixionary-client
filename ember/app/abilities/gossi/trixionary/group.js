import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-delete');
	}),
	canReadSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-sport-relationship-read');
	}),
	canUpdateSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-sport-relationship-update');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-skill-relationship-update');
	}),
	canAddSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-skill-relationship-add');
	}),
	canRemoveSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'group-to-skill-relationship-remove');
	})
});
