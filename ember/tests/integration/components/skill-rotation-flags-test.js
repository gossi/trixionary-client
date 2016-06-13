import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('skill-rotation-flags', 'Integration | Component | skill rotation flags', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{skill-rotation-flags}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#skill-rotation-flags}}
      template block text
    {{/skill-rotation-flags}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
