var App = Class({
	step: null,
	vars: {
		nav: null,

		nav_step1: null,
		nav_step2: null,
		nav_step3: null,

		prev: null,
		next: null,

		pages: null

	},

	defineVariables: function() {
		this.nav = $('.stick-head button');

		this.nav_step1 = $('.nav-step1');
		this.nav_step2 = $('.nav-step2');
		this.nav_step3 = $('.nav-step3');

		this.prev = $('.previous');
		this.next = $('.next');

		this.pages = $('.page');
	},

	initialize: function() {
		this.defineVariables();
		this.setStep(1);

		this.bindEvents();
	},
	bindEvents: function() {
		this.prev.on('click', function() {
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

		this.next.on('click', function() {
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

		this.nav.on('click', function() {
			var btn = $(this);

			if (!btn.prop('disabled')) {
				window.app.setStep(parseInt(btn.attr('data-step')));
			}
		});
	},
	setStep: function(number) {
		this.step = number;

		this.lockPositions();
		this.showPage(this.step);
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
