import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-delete');
	}),
	canReadFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-to-featured_skill-relationship-read');
	}),
	canUpdateFeaturedSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-to-featured_skill-relationship-update');
	}),
	canReadSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-to-skill-relationship-read');
	}),
	canUpdateSkill: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'picture-to-skill-relationship-update');
	})
});
