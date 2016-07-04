import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-delete');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-to-skill-relationship-update');
	}),
	canReadReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-to-reference-relationship-read');
	}),
	canUpdateReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill_reference-to-reference-relationship-update');
	})
});
