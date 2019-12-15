$(function() {

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	/*
	XHR post on data
	<span class="btn btn-secondary" data-simplexhr="{{ route('xhrRequest.post') }}" data-values="{'test': 'hoi'}">Test</span>
	*/
	$(document).on('click', "[data-simplexhr]:not('.xhr-pending'):not(form)", function(e){
		$(e.target).addClass('xhr-pending');
		if (json_values = $(this).data('values')) {
			json_values = json_values.replace(new RegExp("'", 'g'), '"');
		}
		var data = json_values ? JSON.parse(json_values) : {};
		data.call = $(this).data('simplexhr');
	    xhrCall(data, e);
	});

	$(document)
		.on('submit', "form[data-simplexhr]:not('.xhr-pending')", function(e){
			e.preventDefault();
			formSubmit(e.target);
		})
		.on('submit', "form[data-simplexhr][onchange]", function(e) {
			e.preventDefault();
		}).on('change', "form[data-simplexhr][onchange]:not('.xhr-pending')", function(e) {
			e.preventDefault();
			formSubmit($(e.target).parent('form'));
		});

	function formSubmit(form) {
		$(form).addClass('xhr-pending');
		var data = objectifyForm($(form).serializeArray());
		data.call = $(form).data('simplexhr');
	    xhrCall(data, form);
	    return false;
	}

	function xhrCall(data, e) {
		var object = (e.target == undefined ? e : e.target);
		console.log(data);
		$.ajax({
			type:'POST',
			url:'/simplexhrRequest',
			data:data,
			success:function(data){
				$(object).removeClass('xhr-pending');
				
				if ('html' in data && typeof data.html === 'object') {
					Object.keys(data.html).forEach(function (key) {
						if ($(key)[0]) {
							$(key).html(data.html[key]);
						}
					});
				}

				if (typeof $.xhrCustomCallback === 'function') {
					$.xhrCustomCallback(data);
				}
	 		}
	    });
	}

	function objectifyForm(formArray) {
		var returnArray = {};

		if (!Array.isArray(formArray)) {
			return returnArray;
		}
		
		for (var i = 0; i < formArray.length; i++){
			returnArray[formArray[i]['name']] = formArray[i]['value'];
		}

		return returnArray;
	}

});