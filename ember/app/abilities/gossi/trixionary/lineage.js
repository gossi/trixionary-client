import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-delete');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-to-skill-relationship-update');
	}),
	canReadAncestor: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-to-ancestor-relationship-read');
	}),
	canUpdateAncestor: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'lineage-to-ancestor-relationship-update');
	})
});
