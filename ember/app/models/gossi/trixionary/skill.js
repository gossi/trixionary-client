import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo, hasMany } from 'ember-data/relationships';

export default Model.extend({
	name: attr('string'),
	alternativeName: attr('string'),
	slug: attr('string'),
	description: attr('string'),
	history: attr('string'),
	isTranslation: attr('boolean', {defaultValue: false}),
	isRotation: attr('boolean', {defaultValue: false}),
	isAcyclic: attr('boolean', {defaultValue: false}),
	isCyclic: attr('boolean', {defaultValue: false}),
	longitudinalFlags: attr('number'),
	latitudinalFlags: attr('number'),
	transversalFlags: attr('number'),
	movementDescription: attr('string'),
	sequencePictureUrl: attr('string'),
	isComposite: attr('boolean', {defaultValue: false}),
	isMultiple: attr('boolean', {defaultValue: false}),
	multiplier: attr('number'),
	generation: attr('number'),
	importance: attr('number'),
	version: attr('number'),
	versionCreatedAt: attr('date'),
	versionComment: attr('string'),
	sport: belongsTo('gossi.trixionary/sport', {inverse: 'skills'}),
	variations: hasMany('gossi.trixionary/skill', {inverse: 'variationOf'}),
	variationOf: belongsTo('gossi.trixionary/skill', {inverse: 'variations'}),
	multiples: hasMany('gossi.trixionary/skill', {inverse: 'multipleOf'}),
	multipleOf: belongsTo('gossi.trixionary/skill', {inverse: 'multiples'}),
	object: belongsTo('gossi.trixionary/object', {inverse: 'skills'}),
	startPosition: belongsTo('gossi.trixionary/position', {inverse: null}),
	endPosition: belongsTo('gossi.trixionary/position', {inverse: null}),
	featuredPicture: belongsTo('gossi.trixionary/picture', {inverse: null}),
	kstrukturRoot: belongsTo('gossi.trixionary/kstruktur', {inverse: 'rootSkills'}),
	functionPhaseRoot: belongsTo('gossi.trixionary/function-phase', {inverse: 'rootSkills'}),
	children: hasMany('gossi.trixionary/skill', {inverse: 'parents'}),
	parents: hasMany('gossi.trixionary/skill', {inverse: 'children'}),
	parts: hasMany('gossi.trixionary/skill', {inverse: 'composites'}),
	composites: hasMany('gossi.trixionary/skill', {inverse: 'parts'}),
	groups: hasMany('gossi.trixionary/group'),
	lineages: hasMany('gossi.trixionary/lineage'),
	pictures: hasMany('gossi.trixionary/picture'),
	videos: hasMany('gossi.trixionary/video'),
	references: hasMany('gossi.trixionary/reference'),
	kstrukturs: hasMany('gossi.trixionary/kstruktur'),
	functionPhases: hasMany('gossi.trixionary/function-phase')
});
