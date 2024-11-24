(function ($) {
	$.extend($.ui, { DateTimepicker: {} });


	$.datepicker._base_updateDatepicker = $.datepicker._updateDatepicker;
	$.datepicker._updateDatepicker = function (inst) {
		$.datepicker._base_updateDatepicker(inst);

		var val = inst.input.val();

		if (inst.input.hasClass("datetimepicker") == false) return;

		var bottomLayer = $(".ui-datepicker").append("<div class='.datetimepicker' />");
		bottomLayer.append(html1);
		bottomLayer.append("시 ");
		bottomLayer.append(html2);
		bottomLayer.append("분 ");
		bottomLayer.append(html3);
		bottomLayer.append("초 ");

		$.datetimepicker.setTime(val, inst.input);
	};


	function DateTimePicker(options) {

		this.defaultDateTimePicker =
			{
				showTimePicker: false,
				time_format: 'hh:mm:ss'
			};

		hourHTML = $("<select class='dateimepicker-hour' onchange='$.datetimepicker.isDirty = true;'></select>");
		minutsHTML = $("<select class='dateimepicker-minuts' onchange='$.datetimepicker.isDirty = true;'></select>");
		secondHTML = $("<select class='dateimepicker-second' onchange='$.datetimepicker.isDirty = true;'></select>");

		for (i = 1; i <= 24; i++) html1 = hourHTML.append("<option>" + i + "</option");
		for (i = 0; i < 60; i = i + 5) html2 = minutsHTML.append("<option>" + i + "</option");
		for (i = 0; i < 60; i = i + 5) html3 = secondHTML.append("<option>" + i + "</option");
	}

	$.fn.extend({
		datetimepicker: function (options) {

			$.datetimepicker._attach(this, options);
		}
	});

	DateTimePicker.prototype = {
		_initTimePicker: function () {
		},

		isDirty: false,

		innerOption: function ($this) {

			return {
				showOn: "button",
				buttonImage: "css/images/calendar.gif",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				autoSize: true,
				onSelect: function (a, b) {
					var hour = $('.ui-datepicker .dateimepicker-hour').val();
					var minuts = $('.ui-datepicker .dateimepicker-minuts').val();
					var second = $('.ui-datepicker .dateimepicker-second').val();

					var time = hour + ":" + minuts + ":" + second;
					$this.val($this.val() + " " + time);

					$.datetimepicker.setTime($this.val(), $this);

					$.datetimepicker.reset();
				},
				onClose: function (a, b) {
					if ($.datetimepicker.isDirty) {
						$this.val($.datepicker._formatDate(b));

						var hour = $('.ui-datepicker .dateimepicker-hour').val();
						var minuts = $('.ui-datepicker .dateimepicker-minuts').val();
						var second = $('.ui-datepicker .dateimepicker-second').val();

						var time = hour + ":" + minuts + ":" + second;
						$this.val($this.val() + " " + time);

					}
				}
			};
		},

		_attach: function ($this, options) {
			$this.datepicker($.fn.extend(this.innerOption($this), options))
				.addClass("datetimepicker");

			this.setTime($this.val(), $this);

		},

		reset: function () {
			this.isDirty = false;
		},

		setTime: function (format, $this) {
			var arrStr = format.split(' ');

			var hour = 12;
			var minuts = 0;
			var second = 0;

			if (arrStr.length > 1) {
				var strTime = arrStr[1];
				var arr = strTime.split(':');
				if (arr.length > 0) {
					hour = arr[0];
					if (arr.length > 1) minuts = arr[1];
					if (arr.length > 2) second = arr[2];
				}
			}

			$('.ui-datepicker .dateimepicker-hour').val(hour);
			$('.ui-datepicker .dateimepicker-minuts').val(minuts);
			$('.ui-datepicker .dateimepicker-second').val(second);
		}
	};


	$.datetimepicker = new DateTimePicker();
	$.datetimepicker._initTimePicker();

} (jQuery));