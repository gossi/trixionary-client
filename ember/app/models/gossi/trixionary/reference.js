import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { hasMany } from 'ember-data/relationships';

export default Model.extend({
	type: attr('string'),
	title: attr('string'),
	year: attr('number'),
	publisher: attr('string'),
	journal: attr('string'),
	number: attr('string'),
	school: attr('string'),
	author: attr('string'),
	edition: attr('string'),
	volume: attr('string'),
	address: attr('string'),
	editor: attr('string'),
	howpublished: attr('string'),
	note: attr('string'),
	booktitle: attr('string'),
	pages: attr('string'),
	url: attr('string'),
	lastchecked: attr('string'),
	managed: attr('boolean', {defaultValue: false}),
	videos: hasMany('gossi.trixionary/video'),
	skills: hasMany('gossi.trixionary/skill')
});
