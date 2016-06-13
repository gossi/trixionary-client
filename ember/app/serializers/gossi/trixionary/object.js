import JSONAPISerializer from 'ember-data/serializers/json-api';

export default JSONAPISerializer.extend({
	attrs: {
			skillCount: {serialize: false}
	}
});
