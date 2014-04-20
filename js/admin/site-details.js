$(function() {
    var request = {};
    request.keywords = '';

    $('#site-details #keywords').on('keypress', function(e) {
	var code = e.keyCode || e.which;
        if(code == 13) {
            e.preventDefault();
            $('#site-details .keywords').append('<button class="btn" type="button">' + $(this).val() + '</button>');
            $(this).val('');
        }
    });

    $('#site-details .keywords').on('click', '.btn', function() {
        $(this).remove();
    });

    $('#site-details').on('submit', function(event) {
        event.preventDefault();

        $('#site-details .keywords .btn').each(function() {
            request.keywords += $(this).text() + ',';
        });

        request.siteName = $('#site-details #siteName').val();
        request.siteDesc = $('#site-details #siteDesc').val();
        request.domain = $('#site-details #domain').val();

            $.ajax({
			type: "POST",
			url: "/orbit-admin/save.php",
			data: request,
			success: function(data, textStatus, jqXHR) {
				try{
					$result = $.parseJSON(data);
				} catch(error){
					$result = {code:502, message: 'Save failed. Error code: 502'};
				}
				if ($result.code == 200) {
					window.location.hash = "/success";
					var successAlert = createAlert({type:'success', title: $result.message});
					$('#builder').prepend(successAlert);
					successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
					successAlert.show();
				} else {
					window.location.hash = "/error";
					var failAlert = createAlert({type:'error', title: $result.message});
					$('#builder').prepend(failAlert);
					failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
					failAlert.show();
				}
                        },
			error: function() {
				window.location.hash = "/error";
				var failAlert = createAlert({type:'error', title: 'Save failed. Unknown Error'});
				$('#builder').prepend(failAlert);
				failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
				failAlert.show();	
			},
  			cache: false
        });

    });
});