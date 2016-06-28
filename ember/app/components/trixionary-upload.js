import Ember from 'ember';

export default Ember.Component.extend({
	store: Ember.inject.service(),
	session: Ember.inject.service(),

	classNames: ['trixionary-upload'],
	lastFile: null,

	didInsertElement() {
		this._super(...arguments);
		const self = this;

		const host = this.get('store').adapterFor('application').get('host');
		const namespace = this.get('store').adapterFor('application').get('namespace');
		const bearer = this.get('session').get('data.authenticated.data.id');

		this.$('.fileinput-button input').fileupload({
			url: host + '/' + namespace + '/gossi.trixionary/upload',
			headers: {
				Authorization: 'Bearer ' + bearer
			},
			dataType: 'json',
			acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
			done: function (e, data) {
				// console.log(data);
				self.lastFile = data.result;
				if (self.lastFile.error) {
					self.$('.trixionary-upload-filename').text(self.lastFile.error).addClass('text-danger');
				} else {
					self.$('.trixionary-upload-filename').text(self.lastFile.filename).removeClass('text-danger');
					self.$('.trixionary-upload-delete').removeClass('hidden');
					self.$('.trixionary-upload-preview').attr('src', self.lastFile.url).removeClass('hidden');
					self.sendAction('uploaded', self.lastFile);
				}
				self.$('.trixionary-upload-progress').addClass('hidden');
				self.$('.fileinput-button input').val('');
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				self.$('.trixionary-upload-progress .progress-bar').css(
					'width',
					progress + '%'
				);
			}
		}).on('fileuploadadd', function (e, data) {
			if (self.lastFile !== null && data.files[0].name !== self.lastFile.filename) {
				self.delete();
			}
			self.$('.trixionary-upload-progress').removeClass('hidden');
		});
	},

	delete() {
		const self = this;
		const host = this.get('store').adapterFor('application').get('host');
		const namespace = this.get('store').adapterFor('application').get('namespace');
		const bearer = this.get('session').get('data.authenticated.data.id');

		Ember.$.ajax(host + '/' + namespace + '/gossi.trixionary/upload/' + this.lastFile.filename, {
			'method': 'DELETE',
			'headers': {
				'Authorization': 'Bearer ' + bearer
			},
			'dataType': 'json'
		}).done(() => {
			self.$('.trixionary-upload-filename').text('');
			self.$('.trixionary-upload-delete').addClass('hidden');
			self.$('.trixionary-upload-preview').attr('src', '').addClass('hidden');
		});
	},

	actions: {
		delete() {
			this.delete();
			this.sendAction('deleted');
		}
	}
});
