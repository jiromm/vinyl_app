var App = Class({
	step: null,
	vars: {
		locker: null,

		nav: null,

		nav_step1: null,
		nav_step2: null,
		nav_step3: null,

		prev: null,
		next: null,

		pages: null,
		thumbnails: null,
		categories: null,
		fences: null,

		houseUrl: false,
		vinylUrl: false,

		imgBase: false,

		fenceCategoriesSwiper: false,
		fencesSwiper: false
	},
	fenceArchive: {
		1: {
			name: 'Category 1',
			fences: {
				1: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/animals/1'
				},
				2: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/animals/2'
				},
				3: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/animals/3'
				},
				4: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/animals/4'
				},
				5: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/animals/5'
				}
			}
		},
		2: {
			name: 'Category 2',
			fences: {
				1: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nature/1'
				},
				2: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nature/2'
				},
				3: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nature/3'
				},
				4: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nature/4'
				},
				5: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nature/5'
				}
			}
		},
		3: {
			name: 'Category 3',
			fences: {
				1: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nightlife/1'
				},
				2: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nightlife/2'
				},
				3: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nightlife/3'
				},
				4: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nightlife/4'
				},
				5: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/nightlife/5'
				}
			}
		},
		4: {
			name: 'Category 4',
			fences: {
				1: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/food/1'
				},
				2: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/food/2'
				},
				3: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/food/3'
				},
				4: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/food/4'
				},
				5: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/food/5'
				}
			}
		},
		5: {
			name: 'Category 5',
			fences: {
				1: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/city/1'
				},
				2: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/city/2'
				},
				3: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/city/3'
				},
				4: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/city/4'
				},
				5: {
					name: 'Some name',
					url: 'http://lorempixel.com/60/40/city/5'
				}
			}
		}
	},

	defineVariables: function() {
		this.locker = $('.locker');

		this.nav = $('.stick-head button');

		this.nav_step1 = $('.nav-step1');
		this.nav_step2 = $('.nav-step2');
		this.nav_step3 = $('.nav-step3');

		this.prev = $('.previous button');
		this.next = $('.next button');

		this.pages = $('.page');
		this.thumbnails = $('#choose-houses').find('.thumbnail');
		this.fences = $('.fences').find('.swiper-slide');

		this.imgBase = $('.house-container').find('.img-base');
	},

	initialize: function() {
		this.defineVariables();

		this.initOrientationDetector();

		this.setStep(1);

		this.bindEvents();
		this.activateNext(false);

		this.initPlugins();
	},
	initPlugins: function() {
		var catSwipeElement = $('.fence-categories .swiper-container'),
			fenceSwipeElement = $('.fences .swiper-container');

		catSwipeElement.css('width', $(document).width());
		fenceSwipeElement.css('width', $(document).width());

		this.fenceCategoriesSwiper = catSwipeElement.swiper({
			freeMode: true,
			freeModeFluid: true,
			slidesPerView: 3
		});

		this.fencesSwiper = fenceSwipeElement.swiper({
			freeMode: true,
			freeModeFluid: true,
			slidesPerView: 4
		});
	},
	bindEvents: function() {
		var body = $('body');

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
				window.app.selectHouse(thumb);
			}
		});

		body.delegate('.fence-categories a', 'click', function(e) {
			e.preventDefault();

			// Select category
			window.app.getCategories().removeClass('active');
			$(this).addClass('active');

			// Remove available fences
			window.app.fencesSwiper.removeAllSlides();

			// Add selected categorie's fences
			var newSlide = null,
				catId = $(this).attr('data-category-id');

			if (window.app.fenceArchive.hasOwnProperty(catId)) {
				for (var item in window.app.fenceArchive[catId].fences) {
					if (window.app.fenceArchive[catId].fences.hasOwnProperty(item)) {
						newSlide = window.app.fencesSwiper.createSlide('<img src="' + window.app.fenceArchive[catId].fences[item].url + '" data-fence-id="' + item + '">');
						newSlide.append();
					} else {
						throw new DOMException('Archive was empty in category layer.');
					}
				}

				// Select first fence from stack
				window.app.getFences().eq(0).trigger('click');
			} else {
				throw new DOMException('Archive was empty in basic layer.');
			}
		})

		// Choose Fence
		body.delegate('.fences .swiper-slide', 'click', function(e) {
			e.preventDefault();

			window.app.getFences().removeClass('active');
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

		var newSlide = null;

		for (var item in this.fenceArchive) {
			if (this.fenceArchive.hasOwnProperty(item)) {
				newSlide = this.fenceCategoriesSwiper.createSlide('<a href="#" data-category-id="' + item + '">' + this.fenceArchive[item].name + '</a>');
				newSlide.append();
			} else {
				throw new DOMException('Archive was empty in fence layer.');
			}
		}

		this.getCategories().eq(0).trigger('click');
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
	},
	screenLock: function(message) {
		var docWidth = $(document).width(),
			docHeight = $(document).height();

		this.locker.css({
			width: docWidth,
			height: docHeight
		}).removeClass('hidden');

		this.locker.find('.message').text(message);
	},
	screenUnlock: function() {
		this.locker.addClass('hidden');
	},
	initOrientationDetector: function() {
//		setInterval(function() {
//			window.app.detectOrientationChange();
//
//			if (window.app.orientation == 'landscape') {
//				window.app.screenLock('Please change orientation to portrait view.')
//			} else {
//				window.app.screenUnlock();
//			}
//		}, 500);
	},
	detectOrientationChange: function() {
		if ($(window).width() > $(window).height()) {
			this.orientation = 'landscape';
		} else {
			this.orientation = 'portrait';
		}
	},
	getCategories: function() {
		return $('.fence-categories').find('a');
	},
	getFences: function() {
		return $('.fences').find('.swiper-slide');
	}
});

$(function() {
	window.app = new App();
});
