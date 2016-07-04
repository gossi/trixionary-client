import Ember from 'ember';
import moment from 'moment';

export default Ember.Component.extend({
	store: Ember.inject.service(),
	session: Ember.inject.service(),

	isReference: false,
	isVideo: true,
	isFetched: false,
	isFetching: false,
	lastFetchedUrl: null,

	didReceiveAttrs() {
	    this._super(...arguments);

		let video = this.get('video');
		if (!video.get('isNew') && video.get('reference').get('id') !== undefined) {
			this.set('isReference', true);
			this.set('isFetched', true);
		}
	},

	clear() {
		let video = this.get('video');
		let reference = video.get('reference');

		video.set('title', null);
		video.set('description', null);
		video.set('provider', null);
		video.set('width', null);
		video.set('height', null);
		video.set('posterUrl', null);
		video.set('playerUrl', null);

		reference.set('publisher', null);
		reference.set('lastchecked', null);
		reference.set('author', null);
		reference.set('year', null);
	},

	actions: {
		save() {
			let video = this.get('video');
			if (this.get('isVideo')) {
				video.set('reference', null);
			}
			this.sendAction('save', this.get('video'));
		},

		uploaded(data) {
			this.get('video').set('filename', data.filename);
		},

		deleted() {
			this.get('video').set('filename', null);
		},

		fetch(url) {
			if (this.get('lastCheckedUrl') !== url && url !== "") {
				const host = this.get('store').adapterFor('application').get('host');
				const namespace = this.get('store').adapterFor('application').get('namespace');
				const bearer = this.get('session').get('data.authenticated.data.id');

				this.set('isFetching', true);
				Ember.$.ajax(host + '/' + namespace + '/gossi.trixionary/oembed-fetch?url=' + encodeURI(url), {
					'method': 'get',
					'headers': {
						'Authorization': 'Bearer ' + bearer
					},
					'dataType': 'json'
				}).done((data) => {
					let video = this.get('video');
					let reference = video.get('reference');

					video.set('title', data.title);
					video.set('description', data.description);
					video.set('provider', data['provider-name']);
					video.set('width', data.width);
					video.set('height', data.height);
					video.set('posterUrl', data.image);
					video.set('playerUrl', data['player-url']);

					reference.set('publisher', data['provider-name']);
					reference.set('lastchecked', moment().format('YYYY-MM-DD'));
					reference.set('author', data['author-name']);
					let d = new Date(data['published-date']);
					reference.set('year', d.getFullYear());

					this.set('isFetching', false);
					this.set('isFetched', true);
				}).fail(() => {
					this.clear();

					this.set('isFetching', false);
					this.set('isFetched', false);
				});
				this.set('lastCheckedUrl', url);
			}

			if (url === "") {
				this.set('isFetched', false);
			}
		},

		goReference() {
			this.clear();
			this.set('isVideo', false);
			this.set('isReference', true);
		},

		goVideo() {
			this.clear();
			this.set('isReference', false);
			this.set('isVideo', true);
		},

		changeTutorial(e) {
			this.get('video').set('isTutorial', e.target.value === "1");
		}
	}
});
