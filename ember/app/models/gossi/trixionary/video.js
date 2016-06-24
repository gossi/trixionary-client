import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	description: attr('string'),
	url: attr('string'),
	isTutorial: attr('boolean'),
	movender: attr('string'),
	movenderId: attr('number'),
	uploaderId: attr('number'),
	posterUrl: attr('string'),
	provider: attr('string'),
	providerId: attr('string'),
	playerUrl: attr('string'),
	width: attr('number'),
	height: attr('number'),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'videos'}),
	reference: belongsTo('gossi.trixionary/reference', {inverse: 'videos'})
});
