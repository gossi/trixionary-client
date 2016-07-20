import Ember from 'ember';

export default Ember.Component.extend({
	classNames: ['trixionary-video'],

	needsPlayer: Ember.computed(function() {
		return $('#video-player') !== null;
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
	}
});
