import Ember from 'ember';
import DS from 'ember-data';

export default Ember.Controller.extend({
	application: Ember.inject.controller('application'),
	store: Ember.inject.service(),

	statistics: Ember.computed(function () {
		let host = this.get('store').adapterFor('application').get('host');
		let namespace = this.get('store').adapterFor('application').get('namespace');
		let id = this.get('application').get('model').get('id');
		let self = this;

		let promise = new Ember.RSVP.Promise(function (resolve, reject) {
			Ember.$.ajax(host + '/' + namespace + '/gossi.trixionary/statistics/' + id, {
				'method': 'GET',
				'dataType': 'json'
			}).done((response) => {
				resolve(new Ember.RSVP.hash(response));
			}).fail(() => {
				reject({
					skills: 'n/a',
					groups: 'n/a',
					pictures: 'n/a',
					videos: 'n/a',
					references: 'n/a'
				});
			});
		});

		return DS.PromiseObject.create({
			promise: promise
		});
	})
});
