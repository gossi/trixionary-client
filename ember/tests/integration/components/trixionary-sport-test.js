import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('trixionary-sport', 'Integration | Component | trixionary sport', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{trixionary-sport}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#trixionary-sport}}
      template block text
    {{/trixionary-sport}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
