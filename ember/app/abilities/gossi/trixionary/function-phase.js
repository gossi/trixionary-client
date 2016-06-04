import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-delete');
	}),
	canReadRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-root_skill-relationship-read');
	}),
	canUpdateRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-root_skill-relationship-update');
	}),
	canAddRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-root_skill-relationship-add');
	}),
	canRemoveRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-root_skill-relationship-remove');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'function_phase-to-skill-relationship-update');
	})
});
