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

	isGroupRoute: Ember.computed('currentPath', function() {
		return this.get('currentPath').startsWith('group');
	}),

	isPositionRoute: Ember.computed('currentPath', function() {
		return this.get('currentPath').startsWith('position');
	}),

	isSkillRoute: Ember.computed('currentPath', function() {
		return this.get('currentPath').startsWith('skill');
	}),

	nav: Ember.computed('currentPath', function () {
		return {
			"index": {
				"title": this.get('model').get('skillPluralLabel'),
				"active": !this.get('currentPath').startsWith('transitions')
					&& !this.get('currentPath').startsWith('graph')
					&& !this.get('currentPath').startsWith('exercises')
					&& !this.get('currentPath').startsWith('tester')
					&& !this.get('currentPath').startsWith('translate')
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
