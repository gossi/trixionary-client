import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo, hasMany } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	description: attr('string'),
	slug: attr('string'),
	sport: belongsTo('gossi.trixionary/sport', {inverse: 'groups'}),
	skills: hasMany('gossi.trixionary/skill')
});
