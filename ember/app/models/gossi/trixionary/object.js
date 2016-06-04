import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo, hasMany } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	slug: attr('string'),
	fixed: attr('boolean'),
	description: attr('string'),
	sport: belongsTo('gossi.trixionary/sport', {inverse: 'objects'}),
	skills: hasMany('gossi.trixionary/skill')
});
