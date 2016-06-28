import JSONAPISerializer from 'ember-data/serializers/json-api';

export default JSONAPISerializer.extend({
	serializeIntoHash: function(data, type, snapshot, options) {
		this._super(data, type, snapshot, options);
		if (snapshot.adapterOptions && snapshot.adapterOptions.meta) {
			data.data.meta = snapshot.adapterOptions.meta;
		}
	}
});
