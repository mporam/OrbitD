var types = {},
    $el,
    request = {},
    $result,
    carouselControls = '<a class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>',
    carouselPips = $('<ol class="carousel-indicators"></ol>');

window.location.hash = '/';

var buildCarousel = function() {
	var carouselID = $el.attr('id') || 'carousel',
    carouselOptions = {};
	// get options
    carouselOptions = {
        interval: $('#carouselModal #step1 [name="interval"]').val(),
        wrap: $('#carouselModal #step1 [name="wrap"]').is(':checked')
    };
    if ($('#carouselModal #step1 [name="pause"]').is(':checked')) carouselOptions.hover = "hover";
    $('.carousel-control').remove();
    if ($('#carouselModal #step1 [name="arrows"]').is(':checked')) {
        $el.append(carouselControls);
        $('.carousel-control').attr('href', '#' + carouselID);
    }
    $('#main script').remove(); // remove other options
    $el.before('<script>$(function() {$(".carousel").carousel(' + JSON.stringify(carouselOptions) + '); });</script>');
}

var carouselModal = function(step) {

    var slideInner, carouselID;

    if ($el.attr('id').length == 0) {
        $el.attr('id', 'carousel');
        carouselID = 'carousel';
    } else {
         carouselID = $el.attr('id');
    }

    if (typeof step !== 'undefined') {
        $('#carouselModal .step').hide().filter(step).show();
    } else {
        $('#carouselModal .step').hide().filter('#step1').show();
    }
    $('#carouselModal').modal({
		backdrop: 'static',
		keyboard: false,
		show: true
	});

    $('#carouselModal').find('.btn-next').click(function() {
        $('#carouselModal .step').hide();
        $('#carouselModal').find('#step' + $(this).attr('data-step')).show();
        if ('step' + $(this).attr('data-step') == $('#carouselModal .step').last().attr('id')) {

            if ($el.find('.carousel-inner').length == 0) {
               $el.append('<div class="carousel-inner"></div>');
            }
            slideInner = $el.find('.carousel-inner');
            slideInner.html('');

            var pipIndex = 0;

            $('#carouselModal #slides .slide').each(function() {
                var image = $(this).find('[name="slide-image"]').val(),
                    caption = $(this).find('[name="slide-caption"]').val();

                var slideHTML = '<div class="item"><img src="' + image + '" alt="' + caption + '">';
                if (caption != '')  slideHTML += '<div class="carousel-caption">' + caption + '</div>';
                slideHTML += '</div>'
                slideInner.append(slideHTML);

                if ($('#carouselModal #step1 [name="pips"]').is(':checked')) {
                     var pip = $('<li></li>').attr('data-target', '#' + carouselID).attr('data-slide-to', pipIndex);
                     carouselPips.append(pip);
                     pipIndex++;
                }
            });

            if ($('#carouselModal #step1 [name="pips"]').is(':checked')) {
                carouselPips.find('li').first().addClass('active');
                $('.carousel-indicators').remove();
                $el.prepend(carouselPips);
            }

            slideInner.children(":first").addClass('active');

            $('#carouselModal .btn-primary').prop('disabled', false).click(function() {
                buildCarousel(carouselID);
                $('#carouselModal').modal('hide');
            });
        }
    });

    $('#carouselModal #slides').unbind('click'); // remove the click functions before reassigning

    $('#carouselModal #slides').on('click', '[name="slide-image"]', function(e) {
        e.preventDefault();
        var $this = $(this);
        window.KCFinder = {
            callBack: function(url) {
                $this.val(url);
                window.KCFinder = null;
            }
        };
        window.open('/orbit-admin/media/kcfinder/browse.php?type=images', 'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, directories=0, ' + 
'resizable=1, scrollbars=0, width=800, height=600');
    });

    $('#carouselModal #slides').on('click', '.glyphicon-plus', function() {
        var clone = $('#carouselModal .slide').last().clone();
        clone.find('input').val('');
        clone.appendTo('#carouselModal #slides');
    });

    $('#carouselModal #slides').on('click', '.glyphicon-minus', function() {
        $(this).parents('.slide').first().remove();
    });

};

$(function() {

	$('#builder').on('showOptions', function() {
		setInterval(function(){$('#new-module').trigger('autosave')},120000); // auto save function
	});
	
	$('#builder').on('save-success', function(event, id) {
                if (typeof request.id != 'undefined') $('#updateModules').load('/orbit-admin/modules/updateModule.php', request);
		request.id = id;
	});

    if (typeof layoutID != 'undefined') {
         var layoutAlert = createAlert({type:'info', title:'Click here to return to your layout', class: 'left clickable'});
         layoutAlert.click(function() {
             window.location.href = "/orbit-admin/layouts/edit/?id=" + layoutID;
         });
         $('#builder').prepend(layoutAlert);
    }

    $('#contentModal').load('/orbit-admin/includes/modals/contentModal.php', function() {
        CKEDITOR.replace('moduleContent');
    });

	$.post( // gets default modules
		"/orbit-admin/data/get_default_modules.php",
		'',
		function(data, textStatus, jqXHR) {
			var default_modules = data;
                        $('select#type').html('<option selected value="">Please select a module type</option>');
			$.each(default_modules, function(key, value) {
				types[value.name] = value.html;
				$('select#type').append('<option value="' + value.name + '">' + value.name + '</option>');
			});
		}
	).done(function() {
            if (typeof moduleType != 'undefined') { // sets module type drop down on edit page
                 $('select#type option').prop('selected', false);
                 $("select#type option[value='" + moduleType + "']").prop('selected', true);
                 $el = $('#main').find('> *').not('script, style'); // defines $el variable!
                 $('.btn-edit').unbind("click").click(function() { editContent($el)});
                 $el.unbind("click").click(function() { editContent($el)});

		 if (moduleType == 'carousel') {
                    $('#carouselModal').load('/orbit-admin/includes/modals/carouselModal.php', function() {
                        if ($el.find('.carousel-control').length > 0) {
                            $('#carouselModal #step1 [name="arrows"]').prop('checked', true);
                        } else {
                            $('#carouselModal #step1 [name="arrows"]').prop('checked', false);
                        }

                        if ($el.find('.carousel-indicators').length > 0) {
                            $('#carouselModal #step1 [name="pips"]').prop('checked', true);
                        } else {
                            $('#carouselModal #step1 [name="pips"]').prop('checked', false);
                        }

                        var carouselScript = $el.siblings('script').html();
                        carouselScript = carouselScript.substring(38);
                        carouselScript = carouselScript.substring(0, carouselScript.length - 6);
                        carouselScript = $.parseJSON(carouselScript);

                        $('#carouselModal #step1 [name="interval"]').val(carouselScript.interval);

                        if (typeof carouselScript.hover != 'undefined' && carouselScript.hover == 'hover') {
                            $('#carouselModal #step1 [name="pause"]').prop('checked', true);
                        } else {
                            $('#carouselModal #step1 [name="pause"]').prop('checked', false);
                        }

                        if (typeof carouselScript.wrap!= 'undefined' && carouselScript.wrap) {
                            $('#carouselModal #step1 [name="wrap"]').prop('checked', true);
                        } else {
                            $('#carouselModal #step1 [name="wrap"]').prop('checked', false);
                        }

                        $el.find('.item').each(function() {
                            var slideInput = $('#carouselModal #step2 #slides .slide').first().clone();
                            slideInput.find('[name="slide-image"]').val($(this).find('img').attr('src'));
                            slideInput.find('[name="slide-caption"]').val($(this).find('img').attr('alt'));
                            $('#carouselModal #step2 #slides').append(slideInput);
                        });
                        $('#carouselModal #step2 #slides .slide').first().remove();

                        $('#carouselModal .btn-primary').prop('disabled', false).click(function() {
                            buildCarousel();
                            $('#carouselModal').modal('hide');
                        });

                    });
                    $('.module-size').hide().find('select').prop('required', false);
                    $('.btn-edit').unbind("click").click(function() { carouselModal('#step1')});
                    $el.unbind("click");
                }
                  var tmp$el = $el.clone();
                  $('#new-module [name="padding"]').val($el.css('padding'));
                  $('#new-module [name="border-size"]').val(tmp$el.css('border-top-width')); // must use a particular side as jquery sets them seperatly
                  $('#new-module [name="border-style"]').val(tmp$el.css('border-top-style')); // yes this is a horrible hack!?
                  $('#new-module [type="color"][name="border-colour"]').spectrum("set", tmp$el.css('border-top-color')); // inconsistent!?
                  $('#new-module [type="color"][name="background"]').spectrum("set", $el.css('background-color'));
                  if ($el.hasClass('round-corners')) {
                      $('#new-module [name="corners"]').prop('checked', true);
                  }

            };
        });

    if (typeof moduleType == 'undefined') {
        $('.sidebar-options .form-group').not('.default').hide();
    }

    if ($('#new-module [name="type"]').val() == 'carousel') $('.module-size').hide().find('select').prop('required', false);

    var editContent = function($el) {

		if (typeof CKEDITOR.instances.moduleContent != 'undefined') {
        	CKEDITOR.instances.moduleContent.setData($el.html());
		} else {
			$('#moduleContent').val($el.html());
		}

        if (typeof request.name !== 'undefined') {
            $('#contentModal .modal-title').text('Edit ' + request.name + ' Content');
        }

        $('#contentModal').modal('show');

        $('#contentModal [data-action="save"]').click(function() {
			if (typeof CKEDITOR.instances.moduleContent != 'undefined') {
	            $el.html(CKEDITOR.instances.moduleContent.getData());
			} else {
				$el.html($('#moduleContent').val());
			}
			$('#new-module').trigger('autosave'); 
            $('#contentModal').modal('hide');
        });
    };

    if ($('#new-module [name="name"]').val().length > 0) {
		request.name = $('#new-module [name="name"]').val();
		request.oldName = request.name;
	}
	
	var showOptions = function() {
		if (typeof request.type != 'undefined' && request.type.length > 0 && typeof request.name != 'undefined' && request.name.length > 0) {
			$('.sidebar-options .form-group').not('.default').show();
			$('.sidebar-options .form-group .message').hide();
			$('#builder').trigger('showOptions');
		}
	}
	
    $('#new-module [name="name"]').change(function() {
        request.name = $(this).val();
        if (typeof $el !== 'undefined') {
            $el.attr('id', $(this).val().replace(/\s/g, '-'));
            $('.carousel-control').attr('href', '#' + $el.attr('id'));
            $('.carousel-indicators li').attr('data-target', '#' + $el.attr('id'));
        }
		showOptions();
    });

    $('#new-module [name="type"]').change(function() {
        var val = $(this).val();
        $('#main').html(types[val]);
        $el = $('#main').find('> *').not('script, style');
        var moduleID = $('#new-module [name="name"]').val() || '';
        $el.addClass('module').attr('id', moduleID.replace(/\s/g, '-'));
        request.type = val;
		showOptions();
        $('.btn-edit').unbind("click").click(function() {  editContent($el)});
        $el.unbind("click").click(function() { editContent($el)});
        $('.module-size').show().find('select').prop('required', true);
        if (val == 'carousel') {
            if ($('#carouselModal > *').length > 0) {
                carouselModal();
            } else {
                $('#carouselModal').load('/orbit-admin/includes/modals/carouselModal.php', function() {
                    carouselModal();
                });
            }
            $('.module-size').hide().find('select').prop('required', false);
            $('.btn-edit').unbind("click").click(function() { carouselModal('#step1')});
            $el.unbind("click");
        }
        $('#new-module [type="color"][name="background"]').spectrum("set", $el.css('background-color'));
    });

    if (typeof moduleSize != 'undefined') { // sets module size drop down on edit page
        $('#new-module [name="size"] option').prop('selected', false);
        $('#new-module [name="size"] option[value="' + moduleSize + '"]').prop('selected', true);
    }

    

    $('#new-module [name="size"]').change(function() {
        $el.removeClass (function (index, css) {
            return (css.match (/\bcol-lg-\S+/g) || []).join(' ');
        }).addClass('col-lg-' + $(this).val());
        request.size = $(this).val();
    });

    $('#new-module [name="background"]').change(function() {
        if ($(this).val() !== 'none') {
            $('[type="checkbox"][name="background"]').prop('checked', false);
        } else if ($('[type="checkbox"][name="background"]').is(':checked')) {
            $('#new-module [name="background-image"]').val('');
            $('#new-module .background-container').slideUp();
        } else {
            $('#new-module .background-container').slideDown();
        }
        $el.css('background', $(this).val());
    });

    $('#new-module [name="background-image"]').change(function() {
        $('#backgroundModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });

        $('#backgroundModal [name="position"]').change(function() {
            $el.css('background-position', $(this).val());
        });

        $('#backgroundModal [name="repeat-x"]').change(function() {
            if ($(this).is(':checked') && $('#backgroundModal [name="repeat-y"]').is(':checked')) {
                $el.css('background-repeat', 'repeat');
            } else if ($(this).is(':checked')) {
                $el.css('background-repeat', 'repeat-x');
            } else if ($('#backgroundModal [name="repeat-y"]').is(':checked')) {
                $el.css('background-repeat', 'repeat-y');
            } else {
                $el.css('background-repeat', 'no-repeat');
            }
        });

        $('#backgroundModal [name="repeat-y"]').change(function() {
            if ($(this).is(':checked') && $('#backgroundModal [name="repeat-x"]').is(':checked')) {
                $el.css('background-repeat', 'repeat');
            } else if ($(this).is(':checked')) {
                $el.css('background-repeat', 'repeat-y');
            } else if ($('#backgroundModal [name="repeat-x"]').is(':checked')) {
                $el.css('background-repeat', 'repeat-x');
            } else {
                $el.css('background-repeat', 'no-repeat');
            }
        });

        $('#backgroundModal [data-dismiss="modal"]').click(function() {
            $('#new-module [name="background-image"]').val('');
        });

        $('#backgroundModal [data-action="save"]').click(function() {
            // upload image here, somehow.
            $('#backgroundModal').modal('hide');
        });
    });

    $('#new-module [name="border-size"]').change(function() {
        $el.css('border-width', $(this).val());
    });

    $('#new-module [name="border-style"]').change(function() {
        $el.css('border-style', $(this).val());
    });

    $('#new-module [name="border-colour"]').change(function() {
        $el.css('border-color', $(this).val());
    });

    $('#new-module [name="corners"]').change(function() {
        $el.toggleClass('round-corners');
        $('#new-module [name="classes"]').val($el.attr('class'));
    });

    $('#new-module [name="padding"]').change(function() {
        $el.css('padding', $(this).val());
    });

    $('#new-module [name="headCSS"]').change(function() {
        $('head style[data-name="custom"]').remove()
        $('head').prepend('<style data-name="custom" data="send"></style>');
        $('style[data-name="custom"]').html($(this).val());
    });

    $('#new-module [name="classes"]').change(function() {
        $el.addClass($(this).val());
    });

    $('#new-module').on('submit autosave', function(e) {
        e.preventDefault();

        request.size = $('#new-module [name="size"]').val();
        request.type = $('#new-module [name="type"]').val();
        request.element = $('#main').html();
        request.classes = $el.attr('class') || '';
        request.content = $el.html();
        request.inlineCSS = $el.attr('style') || '';
        request.headCSS = '';
        $('style[data="send"]').each(function() {
            request.headCSS   += $(this).html();
        });
        if (typeof mID != 'undefined') request.id = mID;
		if (!request.hasOwnProperty('name')) request.name = $('#new-module [name="name"]').val();

		$.ajax({
			type: "POST",
			url: "/orbit-admin/modules/save.php",
			data: request,
			success: function(data, textStatus, jqXHR) {
				try{
					$result = $.parseJSON(data);
				} catch(error){
					console.log(error);
					$result = {code:502, message: 'Save failed. Duplicate module name.'};
				}
				if ($result.code == 200) {
					window.location.hash = "/success";
					var successAlert = createAlert({type:'success', title: $result.message});
					$('#builder').trigger('save-success', $result.id);
					$('#notifications').append(successAlert);
					successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
                    successAlert.show();
				} else {
					window.location.hash = "/error";
					var failAlert = createAlert({type:'error', title: $result.message});
					$('#builder').trigger('save-fail');
					$('#notifications').append(failAlert);
					failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
                    failAlert.show();
				}
            },
			error: function() { console.log('error'); },
  			cache: false
		});
    });

});