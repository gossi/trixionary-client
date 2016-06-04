import config from '../config/environment';
import Ember from 'ember';

export default Ember.Controller.extend({
	session: Ember.inject.service(),
	i18n: Ember.inject.service(),

	isDevelopment: Ember.computed(function () {
		return config.environment === 'development';
	}),

	isIndex: Ember.computed('currentPath', function() {
		return this.get('currentPath') === 'index';
	}),

	nav: Ember.computed('currentPath', function () {
		return {
			"index": {
				"title": this.get('model').get('skillPluralLabel'),
				"active": this.get('currentPath') === 'index'
			},
			"transitions": {
				"title": this.get('i18n').t('transitions'),
				"active": this.get('currentPath') === 'transitions'
			},
			"graph": {
				"title": this.get('i18n').t('graph'),
				"active": this.get('currentPath') === 'graph'
			},
			"exercises": {
				"title": this.get('i18n').t('exercises'),
				"active": this.get('currentPath') === 'exercises'
			},
			"tester": {
				"title": this.get('i18n').t('tester'),
				"active": this.get('currentPath') === 'tester'
			},
			"translate": {
				"title": this.get('i18n').t('translate'),
				"active": this.get('currentPath') === 'translate'
			}
		};

	}),

	actions: {
		login() {
			let { login, password } = this.getProperties('login', 'password');
			this.get('session').authenticate('authenticator:keeko', login, password).catch(() => {
				// console.log(reason);
			});
		},

		logout() {
      		this.get('session').invalidate();
    	}
	}
});
