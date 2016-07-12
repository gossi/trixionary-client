import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType
});

const slug = keeko && keeko.trixionary && keeko.trixionary.slug ? keeko.trixionary.slug : {};
const skill = slug.skill ? slug.skill : 'skill';
const group = slug.group ? slug.group : 'group';
const obj = slug.object ? slug.object: 'object';

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

  this.route('group', {path: '/' + group + '/:group'}, function() {
    this.route('edit');
  });
  this.route('skill', {path: '/' + skill + '/:skill'}, function() {
    this.route('movement');
    this.route('relationships');
    this.route('pictures');
    this.route('videos');
    this.route('graph');
    this.route('exercises');
    this.route('mistakes');
    this.route('technic-criteria');
    this.route('edit');

    this.route('manage', function() {
      this.route('pictures', function() {
        this.route('add');
        this.route('edit', {path: '/:id'});
      });
      this.route('videos', function() {
        this.route('add');
        this.route('edit', {path: '/:id'});
      });
      this.route('references', function() {
        this.route('add');
        this.route('edit', {path: '/:id'});
      });
    });
    this.route('tutorials');
    this.route('delete');
  });
  this.route('obj', {path: '/' + obj + '/:object'}, function() {
    this.route('edit');
  });
});

export default Router;
