import { moduleForComponent, test } from 'ember-qunit';
import hbs from 'htmlbars-inline-precompile';

moduleForComponent('trixionary-graph-info', 'Integration | Component | trixionary graph info', {
  integration: true
});

test('it renders', function(assert) {
  // Set any properties with this.set('myProperty', 'value');
  // Handle any actions with this.on('myAction', function(val) { ... });

  this.render(hbs`{{trixionary-graph-info}}`);

  assert.equal(this.$().text().trim(), '');

  // Template block usage:
  this.render(hbs`
    {{#trixionary-graph-info}}
      template block text
    {{/trixionary-graph-info}}
  `);

  assert.equal(this.$().text().trim(), 'template block text');
});
