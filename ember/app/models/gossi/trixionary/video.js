import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { hasMany, belongsTo } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	description: attr('string'),
	url: attr('string'),
	isTutorial: attr('boolean'),
	athlete: attr('string'),
	athleteId: attr('number'),
	uploaderId: attr('number'),
	posterUrl: attr('string'),
	provider: attr('string'),
	providerId: attr('string'),
	playerUrl: attr('string'),
	width: attr('number'),
	height: attr('number'),
	featuredSkills: hasMany('gossi.trixionary/skill'),
	featuredTutorialSkills: hasMany('gossi.trixionary/skill'),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'videos'}),
	reference: belongsTo('gossi.trixionary/reference', {inverse: 'videos'})
});
