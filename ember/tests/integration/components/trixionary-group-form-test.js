import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('trixionary-group-form', 'Integration | Component | trixionary group form', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{trixionary-group-form}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#trixionary-group-form}}
      template block text
    {{/trixionary-group-form}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
