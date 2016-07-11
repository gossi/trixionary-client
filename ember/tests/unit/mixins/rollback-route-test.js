import Ember from 'ember';
import RollbackRouteMixin from 'trixionary/mixins/rollback-route';
import { module, test } from 'qunit';

module('Unit | Mixin | rollback route');

// Replace this with your real tests.
test('it works', function(assert) {
  let RollbackRouteObject = Ember.Object.extend(RollbackRouteMixin);
  let subject = RollbackRouteObject.create();
  assert.ok(subject);
});
