(function ($) {
	'use strict';

	var HPM = {

		init: function () {
			this.cache();
			this.bindEvents();
			this.loadFromHash();
			this.renderIcons();
		},

		cache: function () {
			this.$content  = $('#hpm-main-content');
			this.$title    = $('#hpm-tab-title');
			this.$navItems = $('.hpm-nav-item');
		},

		/* =========================
		   INIT LOAD
		========================= */
		loadFromHash: function () {
			var tab = window.location.hash.replace('#', '') || (hpmVars?.defaultTab || 'dashboard');
			this.openTab(tab);
		},

		/* =========================
		   EVENTS
		========================= */
		bindEvents: function () {
			var self = this;

			// Sidebar click
			$(document).on('click', '.hpm-nav-item', function (e) {
				var tab = $(this).data('tab');
				if (!tab || $(this).hasClass('hpm-nav-logout')) return;

				e.preventDefault();
				self.openTab(tab);
			});

			// Back/forward support
			$(window).on('hashchange', function () {
				self.openTab(window.location.hash.replace('#', ''));
			});
		},

		/* =========================
		   TAB CORE
		========================= */
		openTab: function (tab) {
			var self = this;

			var $item = this.$navItems.filter(function () {
				return $(this).data('tab') == tab;
			});

			// fallback
			if (!$item.length) {
				tab = 'dashboard';
				$item = this.$navItems.filter('[data-tab="dashboard"]');
			}

			// active UI
			this.$navItems.removeClass('active');
			$item.addClass('active');

			this.$title.text($.trim($item.text()));

			// update URL (IMPORTANT FIX)
			if (window.location.hash !== '#' + tab) {
				window.location.hash = tab;
			}

			this.showLoader();

			// AJAX
			$.get(hpmVars.ajaxUrl, {
				action: 'hpm_load_tab',
				tab: tab,
				nonce: hpmVars.nonce
			})
			.done(function (res) {
				self.$content.html(res);
				self.renderIcons();
			})
			.fail(function () {
				self.$content.html('<p style="color:red;padding:20px;">Failed to load.</p>');
			});
		},

		/* =========================
		   UI
		========================= */
		showLoader: function () {
			this.$content.html('<div class="hpm-loader"><div class="hpm-spinner"></div></div>');
		},

		renderIcons: function () {
			if (window.lucide) lucide.createIcons();
		}

	};

	$(function () {
		HPM.init();
	});

})(jQuery);