import Ember from 'ember';

const FLAG_ATHLETE = 1;
const FLAG_OBJECT = 2;
const FLAG_SIMULTANEOUS = 4;
const FLAG_ISOLATED = 8;
const FLAG_SAME = 16;
const FLAG_OPPOSITE = 32;

export default Ember.Component.extend({
	i18n: Ember.inject.service(),

	types: Ember.computed(function () {
		return [
			{
				key: 'skill',
				title: this.get('sport').get('skillLabel')
			},
			{
				key: 'composite',
				title: this.get('i18n').t('composite'),
				help: this.get('i18n').t('composite.explanation', {skills: this.get('sport').get('skillPluralLabel')}),
			},
			{
				key: 'multiple',
				title: this.get('i18n').t('multiple'),
				help: this.get('i18n').t('multiple.explanation')
			}
		];
	}),

	synchronizations: Ember.computed(function () {
		return [
			{
				key: 'simultaneous',
				title: this.get('i18n').t('simultaneous')
			},
			{
				key: 'isolated',
				title: this.get('i18n').t('isolated')
			}
		];
	}),

	directions: Ember.computed(function () {
		return [
			{
				key: 'same',
				title: this.get('i18n').t('same')
			},
			{
				key: 'opposite',
				title: this.get('i18n').t('opposite')
			}
		];
	}),

	type: Ember.computed('types', function() {
		return this.get('types')[0];
	}),

	isNonFixedObject: Ember.computed('skill.object', function() {
		let object = this.get('skill').get('object');
		if (object === null) {
			return false;
		}
		return !object.get('fixed');
	}),

	rotation: Ember.computed(function () {
		return {
			longitudinal: {
				athlete: false,
				object: false,
				sync: null,
				direction: null
			},
			latitudinal: {
				athlete: false,
				object: false,
				sync: null,
				direction: null
			},
			transversal: {
				athlete: false,
				object: false,
				sync: null,
				direction: null
			}
		};
	}),

	calculateRotationsFlag(rotation) {
		let flags = 0;
		if (rotation.athlete) {
			flags |= FLAG_ATHLETE;
		}

		if (rotation.object) {
			flags |= FLAG_OBJECT;
		}

		if (rotation.sync && rotation.sync.key === 'simultaneous') {
			flags |= FLAG_SIMULTANEOUS;
		} else if (rotation.sync && rotation.sync.key === 'isolated') {
			flags |= FLAG_ISOLATED;
		}

		if (rotation.direction && rotation.direction.key === 'same') {
			flags |= FLAG_SAME;
		} else if (rotation.direction && rotation.direction.key === 'opposite') {
			flags |= FLAG_OPPOSITE;
		}

		return flags;
	},

	loadRotations(flags) {
		let rotation = {};
		rotation.athlete = (flags & FLAG_ATHLETE) === FLAG_ATHLETE;
		rotation.object = (flags & FLAG_OBJECT) === FLAG_OBJECT;

		if ((flags & FLAG_SIMULTANEOUS) === FLAG_SIMULTANEOUS) {
			rotation.sync = this.get('synchronizations')[0];
		} else if ((flags & FLAG_ISOLATED) === FLAG_ISOLATED) {
			rotation.sync = this.get('synchronizations')[1];
		}

		if ((flags & FLAG_SAME) === FLAG_SAME) {
			rotation.direction = this.get('directions')[0];
		} else if ((flags & FLAG_OPPOSITE) === FLAG_OPPOSITE) {
			rotation.direction = this.get('directions')[1];
		}

		return rotation;
	},

	didReceiveAttrs() {
    	this._super(...arguments);

		let skill = this.get('skill');
		this.get('rotation').longitudinal = this.loadRotations(skill.get('longitudinalFlags'));
		this.get('rotation').latitudinal = this.loadRotations(skill.get('latitudinalFlags'));
		this.get('rotation').transversal = this.loadRotations(skill.get('transversalFlags'));
	},

	actions: {
		save() {
			let skill = this.get('skill');

			// set type
			if (this.get('type').key === 'composite') {
				skill.set('isComposite', true);
			} else if (this.get('type').key === 'multiple') {
				skill.set('isMultiple', true);
			}

			// calculate rotation flags
			skill.set('longitudinalFlags', this.calculateRotationsFlag(this.get('rotation').longitudinal));
			skill.set('latitudinalFlags', this.calculateRotationsFlag(this.get('rotation').latitudinal));
			skill.set('transversalFlags', this.calculateRotationsFlag(this.get('rotation').transversal));
			this.sendAction('save', this.get('skill'));
		},

		changeVariationOf(variationOf) {
			let skill = this.get('skill');
			skill.set('variationOf', variationOf);
			skill.get('parents').pushObject(variationOf);
		},

		changeParts(selection) {
			let skill = this.get('skill');
			skill.set('parts', selection);
			skill.set('parents', selection);
		},

		handleKeydown(dropdown, e) {
			// prevent submitting the form
			if (e.keyCode === 13) {
				e.preventDefault();
			}
	  	}
	},

	searchGroups(group, term) {
		return group.get('title').toLowerCase().indexOf(term.toLowerCase());
	},

	searchSkills(skill, term) {
		return skill.get('name').toLowerCase().indexOf(term.toLowerCase());
	}
});
