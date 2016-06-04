import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-delete');
	}),
	canReadRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-root_skill-relationship-read');
	}),
	canUpdateRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-root_skill-relationship-update');
	}),
	canAddRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-root_skill-relationship-add');
	}),
	canRemoveRootSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-root_skill-relationship-remove');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'kstruktur-to-skill-relationship-update');
	})
});
