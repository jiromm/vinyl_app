var childrenSelect = null;

$(function() {
	$('*[data-toggle="tooltip"]').tooltip();
	$('*[data-toggle="popover"]').popover({
		placement: 'top',
		trigger: 'hover'
	});

	$('.add-residence-address').click(function(e) {
		e.preventDefault();

		var residence_form = $('.residence-address-form-group');

		if (residence_form.hasClass('hide')) {
			residence_form.removeClass('hide').hide().show('slow');
			$(this).text($(this).attr('data-remove')).removeClass('btn-success').addClass('btn-danger');
		} else {
			$(this).text($(this).attr('data-add')).removeClass('btn-danger').addClass('btn-success');
			residence_form.hide('slow', function() {
				$(this).addClass('hide');
			});
		}
	});

	$('#parents-table').dataTable({
		"aoColumnDefs": [{
			'bSortable': false,
			'aTargets': [4]
		}]
	});

	$('#child-table').dataTable({
		"aoColumnDefs": [{
			'bSortable': false,
			'aTargets': [4]
		}]
	});

	$('#attendance-table').dataTable({
		"aoColumnDefs": [{
			'bSortable': false,
			'aTargets': [3, 4]
		}]
	});

	$('.selectize-simple').selectize();

	childrenSelect = $('.selectize-children-list').selectize({
		persist: true,
		maxItems: null,
		valueField: 'id',
		labelField: 'name',
		sortField: 'sort',
		searchField: ['name'],
		render: {
			option: function(item, escape) {
				var tpl = '<span class="label label-danger">Orphan</span>';
				var tags = [];

				if (item.tags.length) {
					var tagList = [];

					for (i = 0; i < item.tags.length; i++) {
						tagList[tagList.length] = '<span class="label label-danger">' + item.tags[i] + '</span>';
					}

					tags = tagList.join(' ');
				}

				return '<div>' +
					'<p><strong>' + item.name + '</strong> <span class="text-muted">' +	item.disease + '</span> </p>' +
					'<div class="tags-autocomplete-positioning">' +
					'Therapies: <span class="label label-success">' + item.attendance + '</span> ' + tags +
					'</div>' +
					'</div>';
			}
		}
	});

	$('.status-list a').click(function(e) {
		e.preventDefault();

		$.getJSON($(this).attr('href'), function(data) {
			if (data.status == 'success') {
				var elem = $('.participants-list').find('li[data-participant-id="' + data.data.id + '"]').find('.status-class');
				elem.removeClass('text-success');
				elem.removeClass('text-warning');
				elem.removeClass('text-danger');
				elem.addClass(data.data.class);

				$.pnotify({
					title: 'Success',
					text: data.message,
					type: 'error',
					shadow: false,
					animate_speed: 'fast'
				});
			} else {
				$.pnotify({
					title: 'Warning',
					text: data.message,
					type: 'error',
					shadow: false
				});
			}
		});
	});

	$('#add-participant').click(function(e) {
		e.preventDefault();

		$.getJSON($(this).attr('href'), function(data) {
			if (data.status == 'success') {
				var participant = data.data.participant;
				$('option[value="' + participant + '"]').remove();

				$.pnotify({
					title: 'Success',
					text: data.message,
					type: 'error',
					shadow: false,
					animate_speed: 'fast'
				});
			} else {
				$.pnotify({
					title: 'Warning',
					text: data.message,
					type: 'error',
					shadow: false
				});
			}
		});
	});

	// replacement
	var participants = $('.selectize-simple.participants');
	var addParticipantForm = $('#add-participant-form');
	var replacement = function() {
		var selectedChild = participants.val();
		var href = addParticipantForm.attr('data-href');

		addParticipantForm.attr('action', href.replace('replacement', selectedChild))};
	participants.change(replacement);
	participants.trigger('change');

	$('.add-new-participant-button').click(function() {
		$(this).hide('slow');
		$('.participants-select-list').hide().removeClass('hide').show('slow');
	});
});
