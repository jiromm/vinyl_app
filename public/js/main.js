var App = Class({
	step: null,
	vars: {
		nav: null,

		nav_step1: null,
		nav_step2: null,
		nav_step3: null,

		prev: null,
		next: null,

		pages: null,
		thumbnails: null,
		categories: null,

		houseUrl: false,
		vinylUrl: false,

		imgBase: false,

		fenceCategoriesSwiper: false
	},

	defineVariables: function() {
		this.nav = $('.stick-head button');

		this.nav_step1 = $('.nav-step1');
		this.nav_step2 = $('.nav-step2');
		this.nav_step3 = $('.nav-step3');

		this.prev = $('.previous button');
		this.next = $('.next button');

		this.pages = $('.page');
		this.thumbnails = $('#choose-houses').find('.thumbnail');
		this.categories = $('.fence-categories').find('a');

		this.imgBase = $('.house-container').find('.img-base');
	},

	initialize: function() {
		this.defineVariables();
		this.setStep(1);

		this.bindEvents();
		this.activateNext(false);

		this.initPlugins();
	},
	initPlugins: function() {
		var catSwipeElement = $('.swiper-container');

		catSwipeElement.css('width', $(document).width());

		this.fenceCategoriesSwiper = catSwipeElement.swiper({
			freeMode: true,
			freeModeFluid: true,
			slidesPerView: 3
		});
	},
	bindEvents: function() {
		// Move Prev
		this.prev.on('click', function(e) {
			e.preventDefault();

			switch (window.app.step) {
				case 1:
					window.app.returnToHome();

					break;
				case 2:
					window.app.setStep(1);

					break;
				case 3:
					window.app.setStep(2);

					break;
				case 4:
					window.app.setStep(3);

					break;
			}
		});

		// Move Next
		this.next.on('click', function(e) {
			e.preventDefault();

			switch (window.app.step) {
				case 1:
					window.app.setStep(2);

					break;
				case 2:
					window.app.setStep(3);

					break;
				case 3:
					window.app.setStep(4);

					break;
			}
		});

		// Move by Navigation
		this.nav.on('click', function(e) {
			e.preventDefault();

			var btn = $(this);

			if (!btn.prop('disabled')) {
				window.app.setStep(parseInt(btn.attr('data-step')));
			}
		});

		// Choose House
		this.thumbnails.on('click', function(e) {
			e.preventDefault();

			var thumb = $(this);

			if (thumb.hasClass('active')) {
				window.app.deselectHouse(thumb);
			} else {
				window.app.selectHouse(thumb);
			}
		});

		// Choose Category
		this.categories.on('click', function(e) {
			e.preventDefault();

			window.app.categories.removeClass('active');
			$(this).addClass('active');
		});
	},
	selectHouse: function(thumb) {
		this.houseUrl = thumb.attr('data-src');
		this.thumbnails.removeClass('active');
		thumb.addClass('active');

		this.activateNext(true);
	},
	deselectHouse: function(thumb) {
		this.houseUrl = false;
		thumb.removeClass('active');

		this.activateNext(false);
	},
	setStep: function(number) {
		// Unlock Next for next action after prev action
		this.activateNext(this.step > number);

		this.step = number;

		this.lockPositions();
		this.showPage(this.step);
		this.highlightStep(this.step);

		switch (this.step) {
			case 1:
				break;
			case 2:
				this.initChooseHouse();

				break;
			case 2:
				this.initChooseFence();

				break;
		}
	},
	initChooseHouse: function() {
		this.imgBase.attr('src', this.houseUrl);
	},
	initChooseFence: function() {

	},
	activateNext: function(status) {
		this.next.prop('disabled', !status);
	},
	activatePrev: function(status) {
		this.prev.prop('disabled', !status);
	},
	highlightStep: function(number) {
		this.nav.removeClass('btn-primary');
		$('.nav-step' + number).addClass('btn-primary');
	},
	showPage: function(number) {
		this.pages.hide();
		$('.page' + number).show();
	},
	lockPositions: function() {
		switch (this.step) {
			case 1:
				this.nav_step1.prop('disabled', false);
				this.nav_step2.prop('disabled', true);
				this.nav_step3.prop('disabled', true);

				break;
			case 2:
				this.nav_step1.prop('disabled', false);
				this.nav_step2.prop('disabled', false);
				this.nav_step3.prop('disabled', true);

				break;
			case 3:
				this.nav_step1.prop('disabled', false);
				this.nav_step2.prop('disabled', false);
				this.nav_step3.prop('disabled', false);

				break;
		}
	},
	returnToHome: function() {
		window.location.href = 'index.html';
	}
});

$(function() {
	window.app = new App();
});
