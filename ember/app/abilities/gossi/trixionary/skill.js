import Ember from 'ember';
import { Ability } from 'ember-can';

export default Ability.extend({
	canPaginate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-paginate');
	}),
	canCreate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-create');
	}),
	canRead: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-read');
	}),
	canUpdate: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-update');
	}),
	canDelete: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-delete');
	}),
	canReadSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-sport-relationship-read');
	}),
	canUpdateSport: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-sport-relationship-update');
	}),
	canReadVariation: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation-relationship-read');
	}),
	canUpdateVariation: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation-relationship-update');
	}),
	canAddVariation: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation-relationship-add');
	}),
	canRemoveVariation: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation-relationship-remove');
	}),
	canReadVariationOf: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation_of-relationship-read');
	}),
	canUpdateVariationOf: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-variation_of-relationship-update');
	}),
	canReadMultiple: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple-relationship-read');
	}),
	canUpdateMultiple: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple-relationship-update');
	}),
	canAddMultiple: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple-relationship-add');
	}),
	canRemoveMultiple: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple-relationship-remove');
	}),
	canReadMultipleOf: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple_of-relationship-read');
	}),
	canUpdateMultipleOf: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-multiple_of-relationship-update');
	}),
	canReadObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-object-relationship-read');
	}),
	canUpdateObject: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-object-relationship-update');
	}),
	canReadStartPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-start_position-relationship-read');
	}),
	canUpdateStartPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-start_position-relationship-update');
	}),
	canReadEndPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-end_position-relationship-read');
	}),
	canUpdateEndPosition: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-end_position-relationship-update');
	}),
	canReadFeaturedPicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-featured_picture-relationship-read');
	}),
	canUpdateFeaturedPicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-featured_picture-relationship-update');
	}),
	canReadKstrukturRoot: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur_root-relationship-read');
	}),
	canUpdateKstrukturRoot: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur_root-relationship-update');
	}),
	canReadFunctionPhaseRoot: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase_root-relationship-read');
	}),
	canUpdateFunctionPhaseRoot: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase_root-relationship-update');
	}),
	canReadChild: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-child-relationship-read');
	}),
	canUpdateChild: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-child-relationship-update');
	}),
	canAddChild: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-child-relationship-add');
	}),
	canRemoveChild: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-child-relationship-remove');
	}),
	canReadPart: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-part-relationship-read');
	}),
	canUpdatePart: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-part-relationship-update');
	}),
	canAddPart: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-part-relationship-add');
	}),
	canRemovePart: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-part-relationship-remove');
	}),
	canReadGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-group-relationship-read');
	}),
	canUpdateGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-group-relationship-update');
	}),
	canAddGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-group-relationship-add');
	}),
	canRemoveGroup: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-group-relationship-remove');
	}),
	canReadReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-reference-relationship-read');
	}),
	canUpdateReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-reference-relationship-update');
	}),
	canAddReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-reference-relationship-add');
	}),
	canRemoveReference: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-reference-relationship-remove');
	}),
	canReadLineage: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-lineage-relationship-read');
	}),
	canUpdateLineage: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-lineage-relationship-update');
	}),
	canAddLineage: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-lineage-relationship-add');
	}),
	canRemoveLineage: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-lineage-relationship-remove');
	}),
	canReadPicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-picture-relationship-read');
	}),
	canUpdatePicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-picture-relationship-update');
	}),
	canAddPicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-picture-relationship-add');
	}),
	canRemovePicture: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-picture-relationship-remove');
	}),
	canReadVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-video-relationship-read');
	}),
	canUpdateVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-video-relationship-update');
	}),
	canAddVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-video-relationship-add');
	}),
	canRemoveVideo: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-video-relationship-remove');
	}),
	canReadKstruktur: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur-relationship-read');
	}),
	canUpdateKstruktur: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur-relationship-update');
	}),
	canAddKstruktur: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur-relationship-add');
	}),
	canRemoveKstruktur: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-kstruktur-relationship-remove');
	}),
	canReadFunctionPhase: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase-relationship-read');
	}),
	canUpdateFunctionPhase: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase-relationship-update');
	}),
	canAddFunctionPhase: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase-relationship-add');
	}),
	canRemoveFunctionPhase: Ember.computed(function() {
		return this.get('session').hasPermission('gossi/trixionary', 'skill-to-function_phase-relationship-remove');
	})
});
