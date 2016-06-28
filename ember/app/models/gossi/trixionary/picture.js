import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	description: attr('string'),
	url: attr('string'),
	thumbUrl: attr('string'),
	photographer: attr('string'),
	photographerId: attr('number'),
	athlete: attr('string'),
	athleteId: attr('number'),
	uploaderId: attr('number'),
	featuredSkill: belongsTo('gossi.trixionary/skill', {inverse: null}),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'pictures'})
});
