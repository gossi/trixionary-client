import Ember from 'ember';

export default Ember.Controller.extend({
	queryParams: ['from', 'to'],
	from: null,
	to: null,

	fromPosition: Ember.computed('from', function() {
		if (this.get('from')) {
			return this.get('model').get('positions').filterBy('slug', this.get('from'))[0];
		}
		return null;
	}),

	toPosition: Ember.computed('to', function() {
		if (this.get('to')) {
			return this.get('model').get('positions').filterBy('slug', this.get('to'))[0];
		}
		return null;
	}),

	skills: Ember.computed('from', 'to', function() {
		let from = this.get('from');
		let to = this.get('to');

		if (from || to) {
			let skills = this.get('model').get('skills');
			if (from) {
				skills = skills.filterBy('startPosition.slug', from);
			}
			if (to) {
				skills = skills.filterBy('endPosition.slug', to);
			}

			return skills;
		}
		return null;
	}),

	searchPosition(position, term) {
		return position.get('title').toLowerCase().indexOf(term.toLowerCase());
	},

	actions: {
		changeFrom(position) {
			if (position) {
				this.set('from', position.get('slug'));
			} else {
				this.set('from', null);
			}
		},

		changeTo(position) {
			if (position) {
				this.set('to', position.get('slug'));
			} else {
				this.set('to', null);
			}

		}
	}
});
