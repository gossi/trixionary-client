import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { hasMany } from 'ember-data/relationships';

export default Model.extend({
	title: attr('string'),
	slug: attr('string'),
	athleteLabel: attr('string'),
	objectSlug: attr('string'),
	objectLabel: attr('string'),
	objectPluralLabel: attr('string'),
	skillSlug: attr('string'),
	skillLabel: attr('string'),
	skillPluralLabel: attr('string'),
	skillPictureUrl: attr('string'),
	groupSlug: attr('string'),
	groupLabel: attr('string'),
	groupPluralLabel: attr('string'),
	transitionLabel: attr('string'),
	transitionPluralLabel: attr('string'),
	transitionsSlug: attr('string'),
	positionSlug: attr('string'),
	positionLabel: attr('string'),
	featureComposition: attr('boolean'),
	featureTester: attr('boolean'),
	isDefault: attr('boolean'),
	objects: hasMany('gossi.trixionary/object'),
	positions: hasMany('gossi.trixionary/position'),
	skills: hasMany('gossi.trixionary/skill'),
	groups: hasMany('gossi.trixionary/group')
});
