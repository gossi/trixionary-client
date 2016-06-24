import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	description: attr('string'),
	url: attr('string'),
	photographer: attr('string'),
	photographerId: attr('number'),
	movender: attr('string'),
	movenderId: attr('number'),
	uploaderId: attr('number'),
	featuredSkill: belongsTo('gossi.trixionary/skill'),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'pictures'})
});
