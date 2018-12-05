(function($) {
	'use strict';

	$(document).ready(function() {
		bmiCalculator.init();
	});

	var bmiCalculator = function() {
		var form = $('.mkd-bmic-form'),
			bmiCalcHolder = $('.mkd-bmi-calculator-holder'),
			data = {},
			notificationHolder = bmiCalcHolder.find('.mkd-bmic-notifications'),
			notificationTextHolder = notificationHolder.find('.mkd-bmic-notification-text'),
			iconHolder = notificationHolder.find('.mkd-bmic-icon-holder');


		var handleForm = function() {
			if(form.length && typeof form !== 'undefined') {
				form.submit(function(e) {
					e.preventDefault();

					data.formData = form.serialize();
					data.action = 'mkd_bmi_calculate';

					notificationHolder.hide();
					notificationTextHolder.html('');
					notificationHolder.removeClass('mkd-bmic-notification-error');
					iconHolder.find('span').removeClass();

					$.ajax({
						data: data,
						dataType: 'json',
						type: 'POST',
						url: mkdBmiCalculatorAjaxUrl,
						success: function(response) {

							if(response.hasError) {
								notificationHolder.addClass('mkd-bmic-notification-error');
							} else {
								iconHolder.find('span').addClass('mkd-bmic-' + response.BMIRank);
								clearForm();
							}

							notificationHolder.show();
							notificationTextHolder.html(response.notificationText);
						}
					});
				});
			}
		};

		var clearForm = function() {
			form.find('input[type="text"], select, textarea').val('');
		};

		var handleCloseIcon = function() {
			var closeIcon = notificationHolder.find('.mkd-bmic-notification-close');

			if(closeIcon.length) {
				closeIcon.on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();

					notificationHolder.fadeOut();
				});
			}
		}

		return {
			init: function() {
				handleForm();
				handleCloseIcon();
			}
		}
	}();
})(jQuery);