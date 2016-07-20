import Ember from 'ember';

export default Ember.Component.extend({
	classNames: ['skill-gallery', 'skill-gallery-videos', 'clearfix'],
	classNameBindings: ['isTiles:skill-gallery-tiles', 'isDetails:skill-gallery-details'],

	view: 'details',

	isTiles: Ember.computed('view', function() {
		return this.get('view') === 'tiles';
	}),

	isDetails: Ember.computed('view', function() {
		return this.get('view') === 'details';
	}),

	didInsertElement() {
		this._super(...arguments);

		const VIDEO_WIDTH = 640;
		let options = {
			iframe: true,
			innerWidth: VIDEO_WIDTH,
			innerHeight: function() {
				var width = $(this).attr('data-width');
				var height = $(this).attr('data-height');
				var ratio = height / width;
				return VIDEO_WIDTH * ratio;
			}
		};
		this.$(".embedded-video").colorbox(options);
		this.$(".video").colorbox({
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
			},
			onOpen: function(e) {
				$('#video-player').removeClass('hidden').attr('src', e.el.src);
			},
			onClosed: function() {
				$('#video-player').addClass('hidden');
			}
		});
	},

	actions: {
		changeView(view) {
			this.set('view', view);
		}
	}
});
