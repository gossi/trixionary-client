import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	slug: attr('string'),
	description: attr('string'),
	sport: belongsTo('gossi.trixionary/sport', {inverse: 'positions'}),
	skill: belongsTo('gossi.trixionary/skill', {inverse: null})
});
