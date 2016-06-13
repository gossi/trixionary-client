import Ember from 'ember';

const FLAG_ATHLETE = 1;
const FLAG_OBJECT = 2;
const FLAG_SIMULTANEOUS = 4;
const FLAG_ISOLATED = 8;
const FLAG_SAME = 16;
const FLAG_OPPOSITE = 32;

export default Ember.Component.extend({
	defined: {
		athlete: FLAG_ATHLETE,
		object: FLAG_OBJECT,
		simultaneous: FLAG_SIMULTANEOUS,
		isolated: FLAG_ISOLATED,
		same: FLAG_SAME,
		opposite: FLAG_OPPOSITE
	}
});
