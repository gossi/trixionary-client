import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { hasMany, belongsTo } from 'ember-data/relationships';

export default Model.extend({
	type: attr('string'),
	title: attr('string'),
	rootSkills: hasMany('gossi.trixionary/skill'),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'kstrukturs'})
});
