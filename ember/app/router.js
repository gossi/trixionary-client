import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType
});

const slug = keeko && keeko.trixionary && keeko.trixionary.slug ? keeko.trixionary.slug : {};
const skill = slug.skill ? slug.skill : 'skill';
const group = slug.group ? slug.group : 'group';

Router.map(function() {
  this.route('exercises');
  this.route('transitions');
  this.route('graph');
  this.route('tester');
  this.route('translate');

  this.route('new', function() {
    this.route('skill', {path: '/' + skill});
    this.route('group', {path: '/' + group});
    this.route('position');
  });

  this.route('group', {path: '/' + group + '/:group'});
  this.route('skill', {path: '/' + skill + '/:skill'});
});

export default Router;
