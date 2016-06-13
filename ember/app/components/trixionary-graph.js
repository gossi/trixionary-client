import Ember from 'ember';

export default Ember.Component.extend({
	data: null,
	dataSet: {
		nodes: new vis.DataSet(),
		edges: new vis.DataSet()
	},
	selected: '',

	graph: null,
	
	setup: function() {
		let container = $('<div>').appendTo(this.$())[0];
		let data = this.get('dataSet');
		let options = {
			stabilize: false,
			stabilizationIterations: 1,
		};

		// Initialise vis.js
		this.graph = new vis.Network(container, data, options);

		// // This sets the new selected item on click
		// this.graph.on('click', function(data) {
		// 	if (data.nodes.length > 0) {
		// 		_this.set('selected', data.nodes[0])
		// 	}
		// });

		$(window).resize(() => {
			this.graph.redraw(); // This makes the graph responsive!!!
		});
	},

	didInsertElement() {
		this._super(...arguments);
		this.setup();
	}
});
