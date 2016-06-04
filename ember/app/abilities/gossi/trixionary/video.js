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
