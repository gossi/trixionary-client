import Ember from 'ember';

export function band(params/*, hash*/) {
	return (params[0] & params[1]) === params[1];
}

export default Ember.Helper.helper(band);