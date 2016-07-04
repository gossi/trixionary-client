import Ember from 'ember';

export default Ember.Component.extend({
	i18n: Ember.inject.service(),

	type: 'book',

	fields: {
		book: {
			visible: ['title', 'publisher', 'year', 'author', 'address', 'edition'],
			required: ['author', 'title', 'publisher', 'year']
		},
		article: {
			visible: ['title', 'year', 'author', 'address', 'journal', 'number', 'volume', 'pages', 'url', 'lastchecked'],
			required: ['author', 'title', 'journal', 'year']
		},
		inbook: {
			visible: ['title', 'booktitle', 'year', 'author', 'publisher', 'address', 'editor', 'volume', 'edition', 'pages'],
			required: ['author', 'title', 'booktitle', 'editor', 'publisher', 'year']
		},
		url: {
			visible: ['title', 'year', 'author', 'url', 'lastchecked'],
			required: ['author', 'title', 'url', 'lastchecked']
		},
		unpublished: {
			visible: ['title', 'year', 'author', 'note', 'school'],
			required: ['title', 'author', 'note']
		},
		bachelorthesis: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'school'],
			required: ['title', 'year', 'author', 'school']
		},
		masterthesis: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'school'],
			required: ['title', 'year', 'author', 'school']
		},
		diplomathesis: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'school'],
			required: ['title', 'year', 'author', 'school']
		},
		phdthesis: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'school'],
			required: ['title', 'year', 'author', 'school']
		},
		habilitationthesis: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'school'],
			required: ['title', 'year', 'author', 'school']
		},
		multimedia: {
			visible: ['title', 'year', 'author', 'publisher', 'address', 'howpublished', 'url', 'lastchecked'],
			required: ['title', 'year', 'author', 'publisher', 'howpublished']
		}
	},

	types: Ember.computed(function () {
		return Object.keys(this.get('fields'));
	}),

	is(field, area) {
		let type = this.get('type');
		if (type in this.get('fields')) {
			let fields = this.get('fields')[type][area];

			return fields.contains(field);
		}

		return false;
	},

	isVisible(field) {
		return this.is(field, 'visible');
	},

	isRequired(field) {
		return this.is(field, 'required');
	},

	// visible fields

	isTitle: Ember.computed('type', function () {
		return this.isVisible('title');
	}),

	isAuthor: Ember.computed('type', function () {
		return this.isVisible('author');
	}),

	isYear: Ember.computed('type', function () {
		return this.isVisible('year');
	}),

	isPublisher: Ember.computed('type', function () {
		return this.isVisible('publisher');
	}),

	isAddress: Ember.computed('type', function () {
		return this.isVisible('address');
	}),

	isEdition: Ember.computed('type', function () {
		return this.isVisible('edition');
	}),

	isJournal: Ember.computed('type', function () {
		return this.isVisible('journal');
	}),

	isVolume: Ember.computed('type', function () {
		return this.isVisible('volume');
	}),

	isNumber: Ember.computed('type', function () {
		return this.isVisible('number');
	}),

	isPages: Ember.computed('type', function () {
		return this.isVisible('pages');
	}),

	isUrl: Ember.computed('type', function () {
		return this.isVisible('url');
	}),

	isLastchecked: Ember.computed('type', function () {
		return this.isVisible('lastchecked');
	}),

	isBooktitle: Ember.computed('type', function () {
		return this.isVisible('booktitle');
	}),

	isEditor: Ember.computed('type', function () {
		return this.isVisible('editor');
	}),

	isSchool: Ember.computed('type', function () {
		return this.isVisible('school');
	}),

	isNote: Ember.computed('type', function () {
		return this.isVisible('note');
	}),

	isHowpublished: Ember.computed('type', function () {
		return this.isVisible('howpublished');
	}),

	// required fields

	isTitleRequired: Ember.computed('type', function () {
		return this.isRequired('title');
	}),

	isAuthorRequired: Ember.computed('type', function () {
		return this.isRequired('author');
	}),

	isYearRequired: Ember.computed('type', function () {
		return this.isRequired('year');
	}),

	isPublisherRequired: Ember.computed('type', function () {
		return this.isRequired('publisher');
	}),

	isAddressRequired: Ember.computed('type', function () {
		return this.isRequired('address');
	}),

	isEditionRequired: Ember.computed('type', function () {
		return this.isRequired('edition');
	}),

	isJournalRequired: Ember.computed('type', function () {
		return this.isRequired('journal');
	}),

	isVolumeRequired: Ember.computed('type', function () {
		return this.isRequired('volume');
	}),

	isNumberRequired: Ember.computed('type', function () {
		return this.isRequired('number');
	}),

	isPagesRequired: Ember.computed('type', function () {
		return this.isRequired('pages');
	}),

	isUrlRequired: Ember.computed('type', function () {
		return this.isRequired('url');
	}),

	isLastcheckedRequired: Ember.computed('type', function () {
		return this.isRequired('lastchecked');
	}),

	isBooktitleRequired: Ember.computed('type', function () {
		return this.isRequired('booktitle');
	}),

	isEditorRequired: Ember.computed('type', function () {
		return this.isRequired('editor');
	}),

	isSchoolRequired: Ember.computed('type', function () {
		return this.isRequired('school');
	}),

	isNoteRequired: Ember.computed('type', function () {
		return this.isRequired('note');
	}),

	isHowpublishedRequired: Ember.computed('type', function () {
		return this.isRequired('howpublished');
	}),

	didReceiveAttrs() {
    	this._super(...arguments);
		let ref = this.get('reference');
		if (ref.get('type') !== '') {
			this.set('type', ref.get('type'));
		}
	},

	actions: {
		save() {
			let ref = this.get('reference');
			ref.set('type', this.get('type'));
			this.sendAction('save', ref);
		},

		handleKeydown(dropdown, e) {
			// prevent submitting the form
			if (e.keyCode === 13) {
				e.preventDefault();
			}
	  	}
	}
});
