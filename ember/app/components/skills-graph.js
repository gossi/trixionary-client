import Ember from 'ember';

export default Ember.Component.extend({
	classNames: ['trixionary-graph'],
	classNameBindings: ['fullscreen'],

	height: '400px',

	graph: null,
	selected: null,
	selecting: false,
	data: null,
	dataSet: {
		nodes: new vis.DataSet(),
		edges: new vis.DataSet()
	},
	fullscreen: false,

	setup: function() {
		this.$().css('height', this.get('height'));
		let container = this.$('.trixionary-graph-canvas')[0];
		let data = this.get('dataSet');
		let options = {
			layout: {
				hierarchical: {
					sortMethod: 'directed',
					direction: 'LR',
					nodeSpacing: 50,
					levelSeparation: 175
				}
			},
			groups: {
				skill: {
					color: {
						background: '#DDD',
						border: '#AAA',
						highlight: {
							background: '#EEE',
							border: '#666'
						}
					}
				},
				variation: {
					color: {
						background: '#FCF8E3',
						border: '#AAA',
						highlight: {
							background: '#EEE',
							border: '#666'
						}
					}
				}
			},
			nodes: {
				borderWidthSelected: 1.1,
				shape: 'box',
				shapeProperties: {
					borderRadius: 5
				},
				labelHighlightBold: false,
				color: {
					background: '#DDD',
					border: '#AAA',
					highlight: {
						background: '#EEE',
						border: '#666'
					}
				}
			},
			edges: {
				arrows: {
					to: {
						enabled: true,
						scaleFactor: 0.7
					}
				},
				selectionWidth: function (width) {
					return width * 1.5;
				},
				color: {
					color: '#AAA',
					highlight: '#777'
				},
				smooth: {
					// type: 'cubicBezier',
					// forceDirection: 'horizontal',
					// roundness: 0.6
					type: 'continuous',
					roundness: 0
				}
			},
			interaction: {
				navigationButtons: true,
			}
		};

		// Initialise vis.js
		this.graph = new vis.Network(container, data, options);
		this.graph.on('selectNode', (e) => {
			this.selectNode(e);
		});
		this.graph.on('deselectNode', (e) => {
			this.deselectNode(e);
		});

		if (this.get('skill')) {
			Ember.run.later(this, () => {
				this.selectNode({nodes: [this.get('skill').get('id')]});
				this.graph.focus(this.get('skill').get('id'), {
					scale: 1
				});
			}, 100);
		}
		keeko.graph = this.graph;
	},

	didReceiveAttrs() {
    	this._super(...arguments);
		let skills = this.get('data');
		let nodes = this.get('dataSet').nodes;
		let edges = this.get('dataSet').edges;
		nodes.clear();
		edges.clear();

		skills.forEach(function(skill) {
			if (skill.get('isMultiple') && skill.get('parents').get('length') === 0) {
				return;
			}

			nodes.add({
				id: skill.get('id'),
				label: skill.get('name'),
				level: skill.get('generation'),
				// group: skill.get('variationOf').get('id') ? 'variation' : 'skill',
				skill: skill
			});

			skill.get('parents').forEach(function (parent) {
				edges.add({
					id: parent.get('id') + '-' + skill.get('id'),
					from: parent.get('id'),
					to: skill.get('id')
				});
			});
		});
	},

	didInsertElement() {
		this._super(...arguments);
		this.setup();
	},

	selectNode(e) {
		if (this.selecting === true) {
			return;
		}
		this.selecting = true;
		let nodes = this.get('dataSet').nodes;
		let id = e.nodes[0];
		let node = nodes.get(id);
		this.set('selected', node.skill);

		// select lineage
		let edges = [];
		node.skill.get('lineages').sortBy("position").forEach((lineage) => {
			edges.push(lineage.get('ancestor').get('id'));
		});
		edges.push(node.skill.get('id'));

		let edgeIds = [];
		edges.reduce(function (a, b) {
			edgeIds.push(a + '-' + b);
			return b;
		});
		this.graph.setSelection({
			nodes: [id],
			edges: edgeIds
		}, {
			highlightEdges: false
		});

		this.selecting = false;
	},

	deselectNode() {
		this.set('selected', null);
	},

	actions: {
		toggleFullscreen() {
			if (BigScreen.enabled) {
				BigScreen.toggle(this.$()[0], () => {
					this.set('fullscreen', true);
				}, () => {
					this.set('fullscreen', false);
				}, function() {
					// some error happened
				});
			}
		}
	}
});
