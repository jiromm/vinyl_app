var App = Class({
	step: null,
	fenceArchive: {},
	houseArchive: {},

	defineVariables: function() {
		this.locker = $('.locker');

		this.nav = $('.stick-head button');

		this.nav_step1 = $('.nav-step1');
		this.nav_step2 = $('.nav-step2');
		this.nav_step3 = $('.nav-step3');

		this.prev = $('.previous button');
		this.next = $('.next button');
		this.submitAppointment = $('.submit-appointment');
		this.submitAppointmentFormButton = $('.appointment-form-submit');

		this.pages = $('.page');
		this.fences = $('.fences').find('.swiper-slide');

		this.houseContainer = $('.house-container');
		this.imgBase = $('.img-base');
		this.draggable = $('.fence-draggable');
		this.fenceChoice = $('.fence-choice');
		this.fenceTools = $('.fence-tools');
		this.fenceEdit = $('.fence-edit');
		this.fenceZoomer = $(".fence-zoomer");
		this.fenceCropper = $(".fence-cropper");
		this.pager = $('.pager');
		this.saveImage = $('.save-image');

		this.imgUploadContainer = $("#upload-photo");
		this.houses = $("#choose-houses");
	},

	initialize: function() {
		this.loadResources(function() {
			window.app.defineVariables();
//			window.app.initOrientationDetector();
			window.app.setStep(1);
			window.app.bindEvents();
			window.app.activateNext(false);
			window.app.initPlugins();
			window.app.preloadFences();
			window.app.draggable.udraggable();
			window.app.imgUploadContainer.find('.loading').hide();
		});
	},
	loadResources: function(callback) {
		$.getJSON("v1/api/house", function(houses) {
			window.app.houseArchive = houses;

			$.getJSON("v1/api/fence", function(fences) { console.log(fences);
				window.app.fenceArchive = fences;

				callback();
			});
		});
	},
	preloadFences: function() {
		var urlList = [];

		for (var categoryId in this.fenceArchive) {
			for (var fenceId in this.fenceArchive[categoryId].fences) {
				urlList[urlList.length] = this.fenceArchive[categoryId].fences[fenceId].original;
			}
		}

		$.imageloader({
			urls: urlList
		});
	},
	initPlugins: function() {
		var catSwipeElement = $('.fence-categories .swiper-container'),
			fenceSwipeElement = $('.fences .swiper-container');

		catSwipeElement.css('width', $(document).width());
		fenceSwipeElement.css('width', $(document).width());

		this.fenceCategoriesSwiper = catSwipeElement.swiper({
			slidesPerView: 1,
			slideActiveClass: 'sp-active',
			onSlideNext: function(swiper) {
				window.app.activateCategory(swiper.activeIndex);
			},
			onSlidePrev: function(swiper) {
				window.app.activateCategory(swiper.activeIndex);
			}
		});

		this.fencesSwiper = fenceSwipeElement.swiper({
			freeMode: true,
			freeModeFluid: true,
			slidesPerView: 4
		});

		this.fenceZoomer.noUiSlider({
			start: 1,
			behaviour: 'slide',
			range: {
				'min': .4,
				'max': 1.4
			}
		});

		this.fenceCropper.noUiSlider({
			start: [0, 100],
			behaviour: 'slide',
			range: {
				'min': 0,
				'max': 100
			}
		});
	},
	activateCategory: function(index) {
		$('.fence-categories a').eq(index).trigger('click');
	},
	bindEvents: function() {
		var body = $('body');

		// Move Prev
		this.prev.on('click', function(e) {
			e.preventDefault();

			window.app.vibrate();

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

			window.app.vibrate();

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

		this.submitAppointment.on('click', function(e) {
			e.preventDefault();

			window.app.next.trigger('click');
		});

		// Move by Navigation
		this.nav.on('click', function(e) {
			e.preventDefault();

			window.app.vibrate();

			var btn = $(this);

			if (!btn.prop('disabled')) {
				window.app.setStep(parseInt(btn.attr('data-step')));
			}
		});

		// Twitter click
		$('.social-twitter').click(function(e) {
			e.preventDefault();

			var width = 575,
				height = 400,
				left   = ($(window).width()  - width)  / 2,
				top    = ($(window).height() - height) / 2,
				url    = this.href,
				opts   = 'status=1' +
					',width='  + width  +
					',height=' + height +
					',top='    + top    +
					',left='   + left;

			window.open(url, 'twitter', opts);

			return false;
		});

		// Choose House
		body.delegate('#choose-houses .thumbnail', 'click', function(e) {
			e.preventDefault();

			window.app.vibrateLong();

			var thumb = $(this);

			if (thumb.hasClass('active')) {
				window.app.deselectHouse(thumb);
			} else {
				window.app.selectHouse(thumb);
				window.app.selectHouse(thumb);
			}
		});

		// Choose Category
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
						newSlide = window.app.fencesSwiper.createSlide('<img src="' + window.app.fenceArchive[catId].fences[item].icon + '" data-category-id="' + catId + '" data-fence-id="' + item + '">');
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
		});

		// Choose Fence
		body.delegate('.fences .swiper-slide', 'click', function(e) {
			e.preventDefault();

			window.app.getFences().removeClass('active');
			$(this).addClass('active');

			window.app.initDrawFence(
				$(this).find('img').attr('data-category-id'),
				$(this).find('img').attr('data-fence-id')
			);

			window.app.activateNext(true);
		});

		// Edit (resize) Fence
		this.fenceEdit.on('click', function(e) {
			e.preventDefault();

			window.app.vibrateLong();

			if (window.app.isEdited) {
				window.app.activateTools(false);
			} else {
				window.app.activateTools(true);
			}
		});

		// Resize fence
		this.fenceZoomer.on('slide', function(e) {
			e.preventDefault();

			var resizeCoeff = $(this).val(),
				currentWidth = window.app.fence.width * resizeCoeff,
				currentHeight = window.app.fence.height * resizeCoeff;

			window.app.houseContainer.find('.fence-covered').css({
				width: currentWidth,
				height: currentHeight
			});

			window.app.fence.lastWidth = currentWidth;
			window.app.fence.lastHeight = currentHeight;
		});

		// Crop fence
		this.fenceCropper.on('slide', function(e) {
			e.preventDefault(); console.log($(this).val());

			var coeff = $(this).val(),
				coeffLeft = coeff[0],
				coeffRight = coeff[1],
				currentLeft = window.app.fence.width * coeffLeft / 100,
				currentRight = window.app.fence.width * coeffRight / 100;

			$('.fence-draggable').css({
				clip: 'rect(0px ' + currentRight + 'px 1000px ' + currentLeft + 'px)'
			});

			window.app.fence.lastLeft = currentLeft;
			window.app.fence.lastRight = currentRight;
		});

		// Image Upload
		this.imgUploadContainer.find('.house-img-form').on('change', function(e) {
			e.preventDefault();

			var formElement = window.app.imgUploadContainer.find('form').eq(0);

			window.app.imgUploadContainer.find('.upload-error-message').text('');
			window.app.imgUploadContainer.find('.upload-success-message').text('');

			$(formElement).ajaxSubmit({
				resetForm: true,
				beforeSubmit: function(formData, jqForm, options) {
					window.app.uploadButtonFreeze();
				},
				success: function(data, statusText) {
					window.app.uploadButtonUnfreeze();

					if (data.status == 'success' && data.code == '0') {
						window.app.houseUrl = data.url;
						window.app.activateNext(true);
						window.app.imgUploadContainer.find('.upload-success-message').html('<img src="' + data.url + '" class="export-bg">');
					} else {
						window.app.imgUploadContainer.find('.upload-error-message').text(data.message);
					}
				},
				error: function() {
					window.app.uploadButtonUnfreeze();

					window.app.imgUploadContainer.find('.upload-error-message').text('An AJAX error occured');
				}
			});
		});

		// Trigger Image Upload
		this.imgUploadContainer.find('.img-upload-button').on('click', function(e) {
			e.preventDefault();

			window.app.imgUploadContainer.find('.house-img-form').trigger('click');
		});

		// Submit Appointment
		this.submitAppointmentFormButton.on('click', function(e) {
			e.preventDefault();

			var form = $(this).closest('form'),
				parent = form.parent(),
				url = form.attr('action'),
				image = $('.export-bg').attr('src');

			$.ajax({
				type: 'POST',
				url: url,
				dataType: "json",
				data: {
					image: image,
					name: $('#name').val(),
					phone: $('#phone').val(),
					email: $('#email').val(),
					remarks: $('#remarks').val()
				}
			}).done(function(data) {
				form.fadeOut('fast', function() {
					if (data.status == 'success') {
						parent.find('.alert-success').fadeIn('fast');
					} else {
						parent.find('.alert-success').fadeIn('fast');
					}
				});
			}).fail(function() {
				form.fadeOut('fast', function() {
					parent.find('.alert-success').fadeIn('fast');
				});
			});
		});

		// Category Arrow click Next
		$('.arrow-cat-left').on('click', function(e) {
			e.preventDefault()
			window.app.fenceCategoriesSwiper.swipePrev();
		});

		// Category Arrow click Prev
		$('.arrow-cat-right').on('click', function(e) {
			e.preventDefault()
			window.app.fenceCategoriesSwiper.swipeNext();
		});

//		var previousOrientation = window.orientation;
//		var checkOrientation = function() {
//			if (window.orientation !== previousOrientation) {
//				previousOrientation = window.orientation;
//			}
//		};
//
//		window.addEventListener("resize", checkOrientation, false);
//		window.addEventListener("orientationchange", checkOrientation, false);
	},
	uploadButtonFreeze: function() {
		this.imgUploadContainer.find('.upload-text').hide();
		this.imgUploadContainer.find('.loading').show('fast');
		this.imgUploadContainer.find('.img-upload-button').prop('disabled', true);
	},
	uploadButtonUnfreeze: function() {
		this.imgUploadContainer.find('.loading').hide();
		this.imgUploadContainer.find('.upload-text').show('fast');
		this.imgUploadContainer.find('.img-upload-button').prop('disabled', false);
	},
	selectHouse: function(thumb) {
		this.houseUrl = thumb.attr('data-src');
		this.getThumbnails().removeClass('active').addClass('xxx');
		thumb.addClass('active');

		this.activateNext(true);
	},
	getThumbnails: function() {
		return $('#choose-houses').find('.thumbnail');
	},
	deselectHouse: function(thumb) {
		this.houseUrl = false;
		thumb.removeClass('active');

		this.activateNext(false);
	},
	hideHeader: function() {
		$('.stick-head').hide();
	},
	hideFooter: function() {
		$('.stick-foot').hide();
	},
	showFooter: function() {
		$('.stick-foot').show();
	},
	setStep: function(number) {
		// Unlock Next for next action after prev action
		this.activateNext(this.step > number);

		switch (this.step) {
			case 1:
				break;
			case 2:
				this.saveCoverImgDetails();
				break;
			case 3:
				break;
		}

		this.step = number;

		this.lockPositions();
		this.showPage(this.step);
		this.highlightStep(this.step);
		this.activateTools(false);
		this.activateFenceEdit(false);
		this.pager.find('.pull-right').html('Next &rarr;');
		this.showFooter();

		switch (this.step) {
			case 1:
				$('.img-base').attr('src', '');
				$('.export-bg').attr('src', '');
				$('.hint').show();
				$('.arrow-cat').hide();
				this.initChooseHouse();

				break;
			case 2:
				this.initChooseFence();
				this.pager.find('.pull-right').html('Finish');
				$('.hint').show();
				$('.arrow-cat').show('fast');

				break;
			case 3:
				this.initExport();
				this.hideFooter();
				$('.hint').hide();
				$('.arrow-cat').hide();

				break;
			case 4:
				this.hideFooter();
				this.hideHeader();
				$('.hint').hide();
				$('.arrow-cat').hide();

				break;
		}
	},
	initExport: function() {
		var imgBase = $('.img-base'),
			imgOver = $('.fence-covered');

		$.ajax({
			type: 'POST',
			url: "api/getFullImage.php",
			dataType: "json",
			data: {
				images: {
					base: imgBase.attr('src'),
					over: imgOver.attr('src')
				},
				position: this.getCoverImgDetails()
			}
		}).done(function(data) {
			$('.export-bg').attr('src', data.url);
			window.app.saveImage.attr('href', data.url);
		});
	},
	saveCoverImgDetails: function() {
		var imgBase = $('.img-base'),
			imgOver = $('.fence-covered');

		this.offset = {
			left: (imgOver.offset().left - imgBase.offset().left) * 500 / imgBase.width(),
			top: (imgOver.offset().top - imgBase.offset().top) * 300 / imgBase.height(),
			overWidth: 500 * imgOver.width() / imgBase.width(),
			overHeight: 300 * imgOver.height() / imgBase.height(),
			baseWidth: 500,
			baseHeight: 300
		}
	},
	getCoverImgDetails: function() {
		return this.offset;
	},
	initDrawFence: function(categoryId, fenceId) {
		this.fenceZoomer.val(1);

		var selectedFence = this.fenceArchive[categoryId].fences[fenceId],
			widthCoeff = this.imgBase.width() / 700,
			heightCoeff = this.imgBase.height() / 420,
			totalWidth = widthCoeff * selectedFence.width,
			totalHeight = heightCoeff * selectedFence.height;

		this.fence = {
			width: totalWidth,
			height: totalHeight,
			lastWidth: totalWidth,
			lastHeight: totalHeight
		};

		this.houseContainer.find('.fence-covered').attr('src', selectedFence.original).animate({
			width: totalWidth,
			height: totalHeight
		});

		this.houseContainer.find('.fence-covered').load(function() {
			window.app.houseContainer.find('.fence-covered').css({
				opacity: 1
			});
		});

		$('.fence-draggable').animate({
			left: parseInt((window.app.imgBase.width() - window.app.fence.width) / 2) + 'px',
			top: parseInt(window.app.imgBase.height() - (window.app.fence.height + (window.app.imgBase.height() / 10))) + 'px'
		}, 'fast');
	},
	initChooseHouse: function() {
		var coeff = .1;

		this.initiated = this.initiated || false;

		if (!this.initiated) {
			$.each(this.houseArchive, function(index, value) {
				var item = $('\
					<div class="col-xs-4 col-md-3 soft-hide">\
						<a href="#" class="thumbnail" data-src="' + value['original'] + '">\
							<img src="' + value['icon'] + '" width="100%">\
						</a>\
					</div>\
				');

				window.app.houses.find('.well-sm').append(item).ready(function() {
					setTimeout(function() {
						item.fadeIn('fast');
					}, (coeff += .2) * 500);
				});
			});

			this.initiated = true;
		}
	},
	activateTools: function(is) {
		if (is) {
			this.isEdited = true;
			this.fenceTools.show();
			this.fenceChoice.hide();
			this.fenceEdit.text('Return');
			$('.arrow-cat').hide();
		} else {
			this.isEdited = false;
			this.fenceTools.hide();
			this.fenceChoice.show();
			this.fenceEdit.text('Edit');
			$('.arrow-cat').show('fast');
		}
	},
	initChooseFence: function() {
		this.activateFenceEdit(true);
		this.imgBase.load(function() {
			window.app.houseContainer.css('height', window.app.imgBase.height());
		}).attr('src', this.houseUrl);

		// Remove available fences
		window.app.fenceCategoriesSwiper.removeAllSlides();

		var newSlide = null;

		for (var item in this.fenceArchive) {
			if (this.fenceArchive.hasOwnProperty(item)) {
				newSlide = this.fenceCategoriesSwiper.createSlide('<a href="#" data-category-id="' + item + '">' + this.fenceArchive[item].name + '</a>');
				newSlide.append();
			} else {
				throw new DOMException('Archive was empty in fence layer.');
			}
		}

		this.imgBase.load(function() {
			window.app.getCategories().eq(0).trigger('click');
		});
	},
	activateFenceEdit: function(is) {
		if (is) {
			this.fenceEdit.show();
		} else {
			this.fenceEdit.hide();
		}
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
	vibrationApi: function() {
		window.navigator.vibrate = window.navigator.vibrate ||
			window.navigator.webkitVibrate ||
			window.navigator.mozVibrate ||
			window.navigator.msVibrate;
	},
	vibrate: function() {
		this.vibrationApi();

		if (window.navigator.vibrate) {
			window.navigator.vibrate([200]);
		}
	},
	vibrateLong: function() {
		this.vibrationApi();

		if (window.navigator.vibrate) {
			window.navigator.vibrate([200, 100, 200]);
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
