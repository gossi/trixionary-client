$(function () {
	// VIDEOS
	const VIDEO_WIDTH = 640;
	var options = {
		iframe: true, 
		innerWidth: VIDEO_WIDTH, 
		innerHeight: function() {
			var width = $(this).attr('data-width');
			var height = $(this).attr('data-height');
			var ratio = height / width;
			return VIDEO_WIDTH * ratio;
		}
	};
	$(".youtube").colorbox(options);
	$(".vimeo").colorbox(options);
	$(".video").colorbox({
		inline: true, 
		innerWidth: VIDEO_WIDTH,
		innerHeight: function() {
			var width = $(this).width();
			var height = $(this).height();
			var ratio = height / width;
			return VIDEO_WIDTH * ratio;
		},
		onComplete: function() {
			$('#cboxLoadedContent').css('overflow', 'hidden');
//	 		document.getElementById('video-player').play();
		},
		onOpen: function(e) {
			$('#video-player').removeClass('hidden').attr('src', e.el.src);
		},
		onClosed: function(e) {
			$('#video-player').addClass('hidden')
		}
	});

	// PICTURES
	$(".pictures").colorbox({
		rel: 'gallery',
		maxHeight: '95%'
	});

	(function ( $ ) {
		// sticky tabs, from: http://aidanlister.com/2014/03/persisting-the-tab-state-in-bootstrap/
	    $.fn.stickyTabs = function() {
	        context = this;
	 
	        // Show the tab corresponding with the hash in the URL, or the first tab.
	        var showTabFromHash = function() {
	          var hash = window.location.hash;
	          var selector = hash ? 'a[href="' + hash + '"]' : 'li.active > a';
	          $(selector, context).tab('show');
	        }
	 
	        // Set the correct tab when the page loads
	        showTabFromHash(context);
	 
	        // Set the correct tab when a user uses their back/forward button
	        window.addEventListener('hashchange', showTabFromHash, false);
	 
	        // Change the URL when tabs are clicked
	        $('a', context).on('click', function(e) {
	          history.pushState(null, null, this.href);
	        });
	 
	        return this;
	    };

	    // gallery switcher
		$.fn.switcher = function() {
			var enableSwitcher = function(context) {
				var gallery = $($(context).attr('href') + ' .gallery');
				var listButton = $('button[data-view=list]', context);
				var detailsButton = $('button[data-view=details]', context);

				listButton.on('click', function () {
					listButton.addClass('active');
					detailsButton.removeClass('active');
					gallery.removeClass('gallery-details');
					gallery.addClass('gallery-list');
				});

				detailsButton.on('click', function () {
					listButton.removeClass('active');
					detailsButton.addClass('active');
					gallery.addClass('gallery-details');
					gallery.removeClass('gallery-list');
				});
			};
			for (var i = 0; i < this.length; i++) {
				enableSwitcher(this[i]);
			}
		};
	}( jQuery ));
	$('.nav-tabs').stickyTabs();
	$('.switcher').switcher();
});

function Structure(options) {
	this.options = options;
	this.network = null;
	this.nodes = null;
	this.edges = null;
	this.deleted = [];

	this.editing = false;
	this.form = null;
	this.titleNode = null;
	this.typeNode = null;
	this.saveButton = null;
	this.data = null;
	this.callback = null;

	this.hierarchicalLayout = {
		nodeSpacing: 25,
		levelSeparation: 75,
		direction: 'DU',
		layout: 'direction'
 	};
	
	this.init();
}

Structure.prototype = {

	init: function() {
		this.nodes = new vis.DataSet(this.options['nodes']);
		this.edges = new vis.DataSet(this.options['edges']);
		this.initNetwork();

		var that = this;
		this.edit = document.getElementById(this.options['id'] + '-edit');
		this.edit.addEventListener('mouseup', function(e) {
			that.setEditing(!that.editing);
		}, false);

		// editing form
		this.titleNode = document.getElementById(this.options['id'] + '-title');
		this.typeNode = $('#' + this.options['id'] + '-type').select2();
		this.saveButton = document.getElementById(this.options['id'] + '-save');
		this.form = document.getElementById(this.options['id'] + '-form');
		this.form.addEventListener('submit', function (e) {
			that.saveForm();
			e.preventDefault();
			e.stopPropagation();
			return false;			
		}, false);
		this.error = document.getElementById(this.options['id'] + '-error');
		this.errorMessage = document.getElementById(this.options['id'] + '-error-message');
		
		// legend
		var list = document.querySelectorAll('#' + this.options['id'] + '-legend li span');
		for (var i = 0; i < list.length; i++) {
			var item = list[i];
			var key = item.className;
			var color = this.options.groups[key].color;
			
			if (color.hasOwnProperty('background')) {
				$(item).css('background-color', color.background);
			}
			
			if (color.hasOwnProperty('border')) {
				$(item).css('border', '1px solid ' + color.border);
			}	
		}
	},

	initNetwork: function() {
		var that = this;
		var container = document.getElementById(this.options['id'] + '-vis');
		var data = {
		    nodes: this.nodes,
		    edges: this.edges
		};

		var options = {
			height: '300px',
			width: '100%',
		 	hierarchicalLayout: this.hierarchicalLayout,
			nodes: {
				borderWidthSelected: 1.1,
				border: 1,
				shape: 'box',
				radius: 5
			},
			groups: this.options['groups'],
			edges: {
				arrowScaleFactor: 0.7,
				style: 'arrow',
				widthSelectionMultiplier: 1.1,
				color: {
					color: '#AAA',
					highlight: '#777'
				},
				inheritColor: false
			},
			smoothCurves: false,
			navigation: false,
			onAdd: function (data, callback) {that.onAdd(data, callback);},
			onEdit: function (data, callback) {that.onEdit(data, callback);},
			onDelete: function (data, callback) {that.onDelete(data, callback);},
			onConnect: function (data, callback) {that.onConnect(data, callback);},
			onEditEdge: function (data, callback) {that.onEditEdge(data, callback);}
		};

		this.network = new vis.Network(container, data, options);
	},
	
	redraw: function() {
		this.initNetwork();
	},

	onAdd: function (data, callback) {
		data.isNew = true;
		data.label = '';
		data.group = this.options['default_group'];
		data.parents = [];
		this.editForm(data, callback);
	},

	onEdit: function (data, callback) {
		this.editForm(data, callback);
	},

	onConnect: function (data, callback) {
		var node = this.nodes.get(data.from);
		node.parents.push(data.to);
		this.nodes.update(node);
		data.id = data.from + '-' + data.to;
		callback(data);
	},
	
	onEditEdge: function (data, callback) {
		var edge = this.edges.get(data.id);
		
		// remove old parent
		var node = this.nodes.get(edge.from);
		for (var i = 0;i < node.parents.length; i++) {
			if (node.parents[i] == edge.to) {
				node.parents.splice(i, 1);
				this.nodes.update(node);
			}
		}
		
		// set new parent
		node = this.nodes.get(data.from);
		node.parents.push(data.to);
		this.nodes.update(node);

		// callback
		callback(data);
		
		// now really it's time to update the edge's id
		var edge = this.edges.get(data.id);
		edge.id = data.from + '-' + data.to;
		this.edges.update(edge);
	},

	onDelete: function (data, callback) {
		
		// delete edges
		for (i = 0; i < data.edges.length; i++) {
			var id = data.edges[i];
			var edge = this.edges.get(id);
			
			// delete child from parent
			var node = this.nodes.get(edge.from);
			for (var j = 0; j < node.parents.length; j++) {
				if (node.parents[j] == edge.to) {
					node.parents.splice(j, 1);
				}
			}
			this.nodes.update(node);
			
			// delete parent in childs
			var node = this.nodes.get(edge.to);
			for (var j = 0; j < node.parents.length; j++) {
				if (node.parents[j] == edge.from) {
					node.parents.splice(j, 1);
				}
			}
		}
		
		// delete nodes
		for (var i = 0; i < data.nodes.length; i++) {
			var id = data.nodes[i];
			var node = this.nodes.get(id);
			if (!node.hasOwnProperty('isNew')) {
				this.deleted.push(node.id);
			}
		}

		callback(data);
	},

	editForm: function (data, callback) {
		this.error.classList.add('hidden');
		this.form.classList.remove('hidden');
		this.titleNode.value = data.label;
		this.typeNode.select2('val', data.group);
		this.titleNode.focus();
		this.deleted = [];

		this.data = data;
		this.callback = callback;
		this.edit.disabled = true;		
	},

	saveForm: function() {
		this.data.label = this.titleNode.value;
		this.data.group = this.typeNode.select2('val');

		this.edit.disabled = false;
		this.form.classList.add('hidden');
		this.callback(this.data);
	},

	setEditing: function(editing) {
		if (editing) {
			this.edit.innerHTML = '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' + this.options.labels.save;

			this.network.setOptions({
				dataManipulation: {
					enabled: true,
					initiallyVisible: true
				},
				hierarchicalLayout: false
			});
						
		} else {
			// integrity check
			console.log('saving....');
			var that = this;
			var nodes = this.nodes.get();
			for (var i = 0; i < nodes.length; i++) {
				var node = nodes[i];
				console.log(node);
				if (node.id != this.options['root'] && (!node.hasOwnProperty('parents') || node.parents.length == 0)) {
					this.error.classList.remove('hidden');
					this.errorMessage.innerHTML = '%title% must be assigned'.replace(/%title%/, node.label);

					return;
				}
			}

			this.edit.disabled = true;
			this.edit.innerHTML = '<span class="glyphicon glyphicon-refresh spin" aria-hidden="true"></span> ' + this.options.labels.saving;
			this.error.classList.add('hidden');

			$.ajax({
				url: this.options['update_url'],
				type: "POST",
				dataType: "json",
				data: JSON.stringify({nodes: nodes, deleted: this.deleted}),
				processData: false,
				success: function (json) {
					for (var oldId in json) {
						var newId = json[oldId];
						
						var edges = that.edges.get({
							filter: function (edge) {
								return edge.from == oldId || edge.to == oldId;
							}
						});
						
						for (var i = 0; i < edges.length; i++) {
							var edge = edges[i];
							if (edge.to == oldId) {
								edge.to = newId;
							} else if (edge.from == oldId) {
								edge.from = newId;
							}
							
							edge.id = edge.from + '-' + edge.to;
							that.edges.update(edge);
						}
						
						var nodes = that.nodes.get({
							filter: function (node) {
								var hasParent = false;
								if (node.parents && node.parents.length) {
									for (var i = 0; i < node.parents.length; i++) {
										hasParent = hasParent || node.parents[i].id == oldId;
									}
								}
								return hasParent;
							}
						});
						
						for (i = 0; i < nodes.length; i++) {
							var node = nodes[i];
							
							if (node.parents && node.parents.length) {
								for (var i = 0; i < node.parents.length; i++) {
									if (node.parents[i].id == oldId) {
										node.parents[i].id = newId;
									}
								}
							}
							that.nodes.update(node);
						}
					}
				},
				complete: function () {
					that.edit.disabled = false;
					that.edit.innerHTML = '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' + that.options.labels.edit;		
				}
			});
			
			this.initNetwork();
		}

		this.editing = editing;
	}
}

var fallback = {
	background: '#D9EDF7',
	border: '#71b0ce',
	highlight: {
		border: '#4b9ac1' 
	}
}; 

Structure.colors = [{
	background: '#DDD',
	border: '#AAA',
	highlight: {
		border: '#888'
	}
}, {
	background: '#DFF0D8',
	border: '#77ba79',
	highlight: {
		border: '#56a957'
	}
}, fallback, {
	background: '#FCF8E3',
	border: '#c7ac7d',
	highlight: {
		border: '#b89559'
	}
}, {
	background: '#fae3c4',
	border: '#ec971f',
	highligh: {
		border: '#c77c11'
	}
}];
