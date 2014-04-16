var request = {},
	usedLayouts = [];

window.location.hash = '/';

var navModal = function(step) {
	
    $('#navModal [data-dismiss="modal"]').click(function() {
        $('style[data="send"]').remove();
        $('#navModal #step1 .has-error').removeClass('has-error');
    });

    if (typeof usedLayouts == 'undefined') var usedLayouts = []; // links for the nav

    if (typeof step !== 'undefined') {
        $('#navModal .step').hide().filter(step).show();
    } else {
        $('#navModal .step').hide().filter('#step1').show();
    }

    $("[type='color']").spectrum();

    $('#navModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });

    $('#navModal #step1 #selectall').change(function() {
        $('#navModal #step1 tbody [type="checkbox"]').prop('checked', $('#navModal #step1 #selectall').is(':checked'));
    });

    $('#navModal [data-step="1"]').click(function() {
        $('#navModal .step').hide();
        $('#navModal').find('#step' + $(this).attr('data-step')).show();
    });

    $('#navModal [data-step="2"]').click(function() {
        if ( $('#navModal #step1 #name').val().length <= 0) {
            $('#navModal #step1 .form-group').first().focus().addClass('has-error');
            return false;
        } else {
            $('#navModal #step1 .has-error').removeClass('has-error');
            request.name = $('#navModal #step1 #name').val();
            request.elid = $('#navModal #step1 #name').val().replace(/\s/g, "-");
            $('#navModal #step3 .preview nav').attr('id', request.elid);
            $('#navModal #step1 input[type="checkbox"]').each(function() {
                var layoutName = $(this).parents('tr').find('td').first().text();
                var self = $(this);

                    for (var i=0, iLen=savedLayouts.length; i<iLen; i++) {
                        if (savedLayouts[i].name == layoutName && !containsObject(savedLayouts[i], usedLayouts) && self.is(':checked')) {
                            savedLayouts[i].custom = false;
                            usedLayouts.push(savedLayouts[i]);
                        } else if (savedLayouts[i].name == layoutName && containsObject(savedLayouts[i], usedLayouts) && !self.is(':checked')) {
                            usedLayouts = removeObject(usedLayouts, 'name', savedLayouts[i].name);
                        }
                    }
            });
            $('#navModal .step').hide();
            $('#navModal').find('#step' + $(this).attr('data-step')).show();
        }
    });

    $('#custom-link-form').submit(function(e) {
        e.preventDefault();
        $('#custom-links').show();
        var button = {};
        button.custom = true;
        button.name = $('[name="link-text"]').val();
        button.location = $('[name="link-location"]').val();
        if(button.location.indexOf("http://") < 0 || button.location.indexOf("https://") < 0){
            button.location = "http://" + button.location;
        }
        var buttonExample = $('<a href="' + button.location + '" class="btn btn-default">' + button.name + '<span class="close">&times;</span></a>');
		$('#custom-links').append(buttonExample);
        usedLayouts.push(button);
        $('#custom-link-form input[type="text"]').val('');
    });
	
	$('#custom-links').on('click', 'a', function(e) {
		e.preventDefault();
		$(this).remove();
		usedLayouts = removeObject(usedLayouts,'name',$(this).text().slice(0, -1));
		$('#custom-link-form input[type="text"]').val('');
	});

    $('#navModal').on('hidden.bs.modal', function (e) {
        $('#navModal .step').hide().filter('#step1').show();
    });

    $('#navModal').find('[data-step="4"]').click(function() {
        $('#navModal .step').hide();
        $('#navModal').find('#step' + $(this).attr('data-step')).show();
        $('#navModal .btn-save').prop('disabled', false);
        $('#step4 #element').html($('#navModal #step3 .tab-content .active .preview').html());
    });

    $('#navModal').find('[data-step="3"]').click(function() {
        $('#navModal #step3 .preview ul').html('');
        usedLayouts.forEach(function(layout) {
            var buttonLocation = layout.location || '/orbit-site/?page=' + layout.name;
            if (layout.custom) { var loc = "custom";} else { var loc = layout.name.replace(/\s/g, "-"); }
            var navButton = "<li data-page='" + loc + "'><a href='" + buttonLocation + "'>" + layout.name + "</a></li>";
            $('#navModal #step3 .preview ul').append(navButton);
        });
        $('#navModal #step3 .preview ul li').first().addClass('active');

        $('#navModal .step').hide();
        $('#navModal').find('#step' + $(this).attr('data-step')).show();

    });

    $('#navModal #navType a').click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    $('#navModal [name="type"]').change(function() {
        $('#navModal .active .preview .nav').removeClass('nav-tabs nav-pills').addClass($(this).val());
    });

    $('#navModal [name="text-color"]').change(function() {
        $('head style[data-name="text-color"]').remove();
        $('head').append('<style data-name="text-color" data="send"></style>');
        $('style[data-name="text-color"]')
            .html('#' + request.elid + ' .nav > li > a,  #' + request.elid + ' .nav > li.active > a,  #' + request.elid + ' .nav-pills > li > a,  #' + request.elid + ' .nav-pills > li.active > a,  #' + request.elid + ' .nav-tabs > li > a,  #' + request.elid + ' .nav-tabs > li.active > a { color: ' + $(this).val() + '!important;}');
    });

    $('#navModal [name="active-color"]').change(function() {
        $('head style[data-name="active-color"]').remove();
        $('head').append('<style data-name="active-color" data="send"></style>'); // yes this is a massive hack, stop complaining!
        $('style[data-name="active-color"]')
            .html('#' + request.elid + ' .nav > li.active > a,  #' + request.elid + ' .nav-pills > li.active > a,  #' + request.elid + ' .nav-tabs > li.active > a { background-color: ' + $(this).val() + '!important;}  #' + request.elid + ' .nav > li > a:hover,  #' + request.elid + ' .nav-tabs > li > a:hover,  #' + request.elid + ' .nav-pills > li > a:hover,  #' + request.elid + ' .nav-pills > li.active > a:hover,  #' + request.elid + ' .nav-tabs > li.active > a:hover { color: ' + $(this).val() + '!important;}');
    });

    $('#navModal [name="hover-color"]').change(function() {
        $('head style[data-name="hover-color"]').remove()
        $('head').append('<style data-name="hover-color" data="send"></style>');
        $('style[data-name="hover-color"]')
            .html('#' + request.elid + ' .nav > li > a:hover, #' + request.elid + ' .nav > li > a.hoverexp, #' + request.elid + ' .nav > li.active > a:hover,  #' + request.elid + ' .nav-pills > li > a:hover,  #' + request.elid + ' .nav-pills > li.active > a:hover,  #' + request.elid + ' .nav-tabs > li > a:hover,  #' + request.elid + ' .nav-tabs > li.active > a:hover { background-color: ' + $(this).val() + '!important;}');
    });

    $('#navModal [name="bg-color"]').change(function() {
        $('#navModal #step3 .active .preview nav').css('background-color', $(this).val());
    });
	
	$('#navModal [name="corners"]').change(function() {
        $('#navModal #step3 .active .preview nav').toggleClass('round-corners');
    });
};



$(function() {
	
	$('#navModal').load('/orbit-admin/includes/modals/navModal.php');

	$('#create-nav').click(function(e) {
		$('#navModal').load('/orbit-admin/includes/modals/navModal.php', function() {
			navModal();
		});
    });

    $('#navs.item-list li').mouseover(function() {
        var thisNav = searchArray($(this).data('id'), 'id', navs);
        $('#quickPreview').html(thisNav.element);
		$('#quickPreview').append("<style>" + thisNav.headCSS + "</style>");
    });

    $('#navs.item-list li').click(function(e) {
        e.stopPropagation();
        var nav = searchArray($(this).data('id'), 'id', navs);
        $('#navModal #step1 #name').val(nav.name);
        $('#navModal #step1 tr input').prop('checked', false);

        $('#navModal #step1 tbody tr').each(function(index) {
            var name = $(this).find("td:first-child").text().replace(/\s/g, "-");
            if (nav.element.indexOf('data-page="' + name + '"') >= 0) {
                $(this).find('input').prop("checked", true);
            }
        });
        if ($('#navModal #step1 td input:checked').length == $('#navModal #step1 td input').length) $('#navModal #step1 th input').prop('checked', true);

        var $el = $(nav.element);
         $('#custom-links').show();
         $el.find('li[data-page="custom"]').each(function() {
            var button = $(this);
            var buttonExample = '<a href="' + button.find('a').attr('href') + '" class="btn btn-default" onclick="javascript:return false;">' + button.text() + '<span class="close">&times;</span></a>';
            $('#custom-links').append(buttonExample);
            var custom = {};
            custom.custom = true;
            custom.name = button.text();
            button.location = button.find('a').attr('href');
            usedLayouts.push(custom);
        });

        navModal();

        $('#quickPreview li a').last().addClass('hover');
		$('#step3 [name="text-color"]').spectrum("set", $('#quickPreview li a').first().css('color')).trigger('change');
		$('#step3 [name="active-color"]').spectrum("set", $('#quickPreview li.active a').first().css('background-color')).trigger('change');
		$('#step3 [name="hover-color"]').spectrum("set", $('#quickPreview li a.hover').last().css('background-color')).trigger('change');
		$('#step3 [name="bg-color"]').spectrum("set", $('#quickPreview nav').css('background-color')).trigger('change');

		if ($('#quickPreview nav').hasClass('round-corners')) {
			$('#step3 .preview nav').addClass('round-corners');
			$('#navModal [name="corners"]').prop('checked', true);
		} else {
			$('#step3 .preview nav').removeClass('round-corners');
			$('#navModal [name="corners"]').prop('checked', false);
		}

		$('#quickPreview').html("Hover over a navigation on the left to view here");

    });

        $('#navModal').on('click', '.btn-save', function() {
            var $el = $('#navModal #step4 #element nav');

            request.name = $('#navModal [name="name"]').val();
            request.oldName = request.name; // this needs updating!...not sure why i wrote this?!
            request.type = 'navigation';
            request.element = $('#navModal #step4 #element').html();
            request.classes = $el.attr('class');
            request.content = $el.html();
            request.inlineCSS = $el.attr('style') || '';
            request.headCSS = '';
            $('style[data="send"]').each(function() {
                request.headCSS   += $(this).html();
            });
            $('#navModal').modal('hide');

		$.ajax({
			type: "POST",
			url: "/orbit-admin/modules/save.php",
			data: request,
			success: function(data, textStatus, jqXHR) {
				try{
					$result = $.parseJSON(data);
				} catch(error){
					$result = {code:502, message: 'Save failed. Duplicate navigation name.'};
				}
				if ($result.code == 200) {
					window.location.hash = "/success";
					var successAlert = createAlert({type:'success', title: $result.message});
					$('#notifications').append(successAlert);
					successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
                                        successAlert.show();
                                        $('#updateModules').load('/orbit-admin/modules/updateModule.php', request);
                                        //setTimeout(function(){location.reload(); },4000);
				} else {
					window.location.hash = "/error";
					var failAlert = createAlert({type:'error', title: $result.message});
					$('#notifications').append(failAlert);
					failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
                                        failAlert.show();
				}
                        },
  			cache: false
		});
    });

});