import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('trixionary-sport-nav', 'Integration | Component | trixionary sport nav', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{trixionary-sport-nav}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#trixionary-sport-nav}}
      template block text
    {{/trixionary-sport-nav}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
