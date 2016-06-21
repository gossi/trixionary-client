// overwrite: false
import Model from 'ember-data/model';
import attr from 'ember-data/attr';
import { belongsTo } from 'ember-data/relationships';

export default Model.extend({
	position: attr('number'),
	skill: belongsTo('gossi.trixionary/skill', {inverse: 'lineages'}),
	ancestor: belongsTo('gossi.trixionary/skill', {inverse: null})
});
