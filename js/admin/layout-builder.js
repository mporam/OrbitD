var $container = $('<div class="container"></div>'),
    layouts = {},
    request = {},
    modules = {},
    layout, container, module, content, offset;

$('#builder').on('save-success', function(event, id) {
    if (typeof request.id != 'undefined') $('#updateNavs').load('/orbit-admin/navs/updateNavs.php', request);
	request.id = id;
});

$('#builder').on('navUpdate', function() {
    request.oldName = request.name;
});

var addEditModuleButtons = function(items) {
    $('#offsetModal').load('/orbit-admin/includes/modals/offsetModal.php', function() {
        $('#offsetModal [data-action="add-offset"]').click(function() {
            offset.find('.badge').remove();
            offset.removeClass (function (index, css) {
                return (css.match (/\bcol-lg-offset-\S+/g) || []).join(' '); // yes im using a regex, fuck you!
                })
                .addClass('col-lg-offset-' + $('#offsetModal select').val())
                .find('.btn.offset')
                .append('<span class="badge">' + $('#offsetModal select').val() + '</span>');
            $('#offsetModal').modal('hide')
        });
    });
    items.each(function() {
        $(this)
            .addClass('editable')
            .prepend("<div class='actions'><a href='#' class='btn btn-danger delete'>Delete Module</a><a href='#' class='btn btn-info offset'>Module Offset</a><a href='#' class='btn btn-info edit'>Edit Module</a></div>")
            .on('click', '.btn.edit', function(e) {
                e.preventDefault();
                $('#edit-layout form').trigger('autosave'); // automatically saves the layout
                var moduleName = $(this).parents('.module').attr('id').replace("-", " ");
                $('#builder').on('save-success', function(event, id) { // fire on successful save
                    window.location.href = '/orbit-admin/modules/edit/?id=' + modules[moduleName].id + '&layoutID=' + id;
                }).on('save-fail', function() {
                    var alert = createAlert({type:'error', title:'Autosave failed. Please save this layout before editing a module.'});
                    $('#builder').prepend(alert);
                    alert.text('').delay(4000).show();
		    alert.delay(7000).fadeOut(1000, function() { $(this).remove(); });
                });
            }).on('click', '.btn.offset', function(e) {
                e.preventDefault();
                $('#offsetModal').modal('show');
                offset = $(this).parents('.module').first();
            }).on('click', '.btn.delete', function(e) {
                e.preventDefault();
                $(this).parents('.editable').first().remove();
            });
    });

};

var editModules = function() {
    $('#main.ui-sortable').sortable("destroy");
    $('.content .actions').remove();

    addEditModuleButtons($('.module'));

    $(".content").removeClass('editable').sortable({
        placeholder: "drop-target",
        items: '.module',
        start: function(e, ui) {
            var height = (ui.item.height() - 2); // -2 accounts for the border on the placeholder
            ui.placeholder.height(height).addClass(ui.item.attr('class'));
        }
    });
};


var addEditContentButtons = function(items) {
	$('#editContentContainer').load('/orbit-admin/includes/modals/editContentContainer.php');
	var $thisContent;
	var editButton = $("<a href='#' class='btn btn-info edit'>Edit Container</a>");

        var deleteButton = $("<a href='#' class='btn btn-danger delete'>Delete Container</a>");

    var actions = $("<div class='actions'></div>").prepend(editButton).prepend(deleteButton);

    items.each(function() {
       $(this).find('.actions').remove();

        $(this)
             .addClass('editable')
            .prepend(actions.clone());

        $(this).find('.btn.edit').click(function(e) {
                e.preventDefault();
                $thisContent = $(this).parents('.content').first();
                var width, offset,
                w = $thisContent.attr('class').match(/(?:col-lg-)[0-9]{1,2}/),
                m = $thisContent.attr('class').match(/(?:col-lg-offset-)[0-9]{1,2}/);
                if (w != null) {width = w.toString().substring(7);} else {width = '12';};
                if (m != null) {offset = m.toString().substring(14);} else {offset = '0';};
                $('#editContentContainer [name="width"]').find('[value="' + width + '"]').prop('selected', 'selected');
                $('#editContentContainer [name="offset"]').find('[value="' + offset + '"]').prop('selected', 'selected');
				$('#editContentContainer').modal('show')

                $('#editContentContainer [data-action="edit-container"]').click(function() {
                    $thisContent
                        .removeClass (function (index, css) {
                            return (css.match (/\bcol-lg-\S+/g) || []).join(' '); // yes im using a regex, fuck you!
                        }).addClass('col-lg-' + $('#editContentContainer [name="width"]').val())
                        .removeClass (function (index, css) {
                            return (css.match (/\bcol-lg-ofset-\S+/g) || []).join(' ');
                        }).addClass('col-lg-offset-' + $('#editContentContainer [name="offset"]').val());

                    $('#editContentContainer').modal('hide');
                });
            });

            $(this).find('.btn.delete').click(function(e) {
                e.preventDefault();
                $(this).parents('.editable').first().remove();
            });
    });


};

var editContent = function() {
    $('.module').removeClass('editable');
    $('.module .actions').remove();
    $(".content.ui-sortable").sortable("destroy");

    addEditContentButtons($('.content'));

    $("#main").sortable({
        placeholder: "drop-target",
        items: '.content',
        start: function(e, ui) {
            var height = (ui.item.height() - 2); // -2 accounts for the border on the placeholder, this is obviously fool proof!
            ui.placeholder.height(height).addClass(ui.item.attr('class'));
        }
    });
};

var createLayout = function(layout, container) {
    $('#main').html('');
    if (container) {
        $('#main').html($container.html(layouts[layout]));
    } else {
        $('#main').html(layouts[layout]);
    }
	$main = $('#main');
};

$(function() {

	setInterval(function(){$('#edit-layout form').trigger('autosave')},300000); // auto save function

    if ($('[name="name"]').val().length > 0) request.oldName = $('[name="name"]').val();

    $.ajax({
		type: "POST",
		url: '/orbit-admin/data/get_saved_modules.php',
		data: '',
		success: function(data) {
			$.each(data, function(key, value) {
				modules[value.name] = value;
			});
		}
    });

	$('#layoutChoice').load('/orbit-admin/includes/modals/layoutChoice.php', function(response, status, xhr) {
		if (status=="error") window.location.href="/orbit-admin/layouts/";
		
		$.ajax({
			type: "POST",
			url: '/orbit-admin/data/get_default_layouts.php',
			data: '',
			success: function(data) {
				$('#layoutChoice .center').html('');
				$.each(data, function(key, value) {
				layouts[value.name] = value.html;
				$('#layoutChoice .center').append('<a data-name="' + value.name + '" class="btn btn-default btn-lg"><img class="img-rounded" src="/img/icons/' + value.name + '-layout.gif">' + value.displayName + '</a>');
			});
			}
		}).done(function() {
			$('#layoutChoice .modal-body .btn').click(function() {
				$('#layoutChoice .btn.active').removeClass('active');
				$(this).addClass('active');
				$('#layoutChoice [data-action="save"]').prop("disabled", false);
			});
		});
		
		$('#layoutChoice [name="container"]').change(function() {
			$('#layoutChoice .modal-body .center').toggleClass('container-layout');
			if ($(this).is(':checked')) {
				$('#edit-layout [name="container"]').prop('checked', 'checked');
				$('.container-color').show();
			} else {
				$('#edit-layout [name="container"]').prop('checked', false);
				$('.container-color').hide();
			}
		});
	
		$('#layoutChoice [data-action="save"]').click(function() {
			var useLayout = $('#layoutChoice .modal-body .active').attr('data-name');
			var hasContainer = $('#layoutChoice .modal-body .center').hasClass('container-layout');
			createLayout(useLayout, hasContainer);
			addEditContentButtons($('.content'));
			$('#layoutChoice').modal('hide').on('hidden.bs.modal', function () {
				$('#layoutChoice .modal-body .alert').remove();
				$('#layoutChoice .modal-footer [data-dismiss="modal"]').remove();
				$('#layoutChoice .modal-body').prepend(createAlert({type:'error', title:'Changing layout will remove all current layout containers and modules!'}));
				$('#layoutChoice .modal-footer').prepend('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>');
				$('#layoutChoice .modal-footer a').remove();
			});
		});
		
	});
	
    $main = $('#main');

    $('#edit-layout [name="name"]').change(function() {
        $(this).next().find('span').text($(this).val().replace(/\s/g,"-"));
    });
	
	$('#edit-layout [name="homepage"]').change(function() {
		if ($(this).is(':checked')) {
			$('#edit-layout [name="name"]').prop('disabled', true).val('index');
		} else {
			$('#edit-layout [name="name"]').prop('disabled', false);
		}
	});

	$('#edit-layout [name="homepage"]').parent().hover(function() {
		if ($('#edit-layout [name="homepage"]').is(':disabled')) {
            $(this).tooltip('toggle');
		}
	});

    $('a[data-action="layout-choice"]').click(function(e) {
        e.preventDefault();
        $('#layoutChoice').modal({
            backdrop: true,
            keyboard: true,
            show: true
        });
    });

    $('#edit-layout [name="container"]').change(function() {
        var html;
        $('#layoutChoice .modal-body .center').toggleClass('container-layout');
        if ($(this).is(':checked')) {
            html = $main.html();
            $main.html($container.html(html));
            $('#layoutChoice [name="container"]').prop('checked', 'checked');
            $('.container-color').slideDown();
        } else {
            $('#layoutChoice [name="container"]').prop('checked', false);
            html = $main.find('.container').html();
            $main.html(html);
            $('.container-color').slideUp();
        }
    });

    if ($('#main > *').length == 0) {
        $('#layoutChoice').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    if (!$('[name="container"]').is(':checked')) {
        $('.container-color').hide();
    } else {
        $('[name="container-colour"]').spectrum("set", $('.container').css('background-color'));
    }

    var bgcol = $main.css('background-color'),
          bgimg = $main.css('ectrumgetcol');

    if ($main.css('background-color') == 'transparent') bgcol = '#ffffff';
    if ($main.css('ectrumgetcol') == 'none') bgimg = '';

    $('[name="background-colour"]').spectrum("set", bgcol);
    $('[name="ectrumgetcol"]').val(bgimg);

    editContent();

    $('#editSettings a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
        if ($(this).attr('href') == "#module") {
            editModules();
        } else {
            editContent();
        }
    });

    $('#edit-layout [name="script"]').change(function() {
        $main.prepend('<script>' + $(this).val() + '</script>');
    });

    $('a[data-action="add-content"]').click(function(e) {
        e.preventDefault();
		if ($('#main .container').length > 0) {
			$main.find('.container').prepend('<div class="editable content col-lg-12"></div>');
		} else {
			$main.prepend('<div class="editable content col-lg-12"></div>');	
		}
        addEditContentButtons($('#main > .content'));
    });

    $('a[data-action="select-module"]').click(function(e) {
        e.preventDefault();
        if ($('.content').length > 0) {
            $('#addModule').load('/orbit-admin/includes/modals/addModule.php', function() {
                $('#addModule .list-group').html('');
                for (var key in modules) {
                    $('#addModule .list-group').append('<a class="list-group-item" href="' + key + '">' + key + '</a>');
                 };

                 $('#addModule .list-group-item').click(function(e) {
                    e.preventDefault();
                    $(this).parent().find('.active').removeClass('active');
                    $(this).addClass('active');
                    $('#addModule [data-action="add-module"]').prop("disabled", false);

                    module = $(this).attr('href');
                    $('#addModule #preview .panel-body').html(modules[module].element);
                });

                $('#addModule [data-action="add-module"]').click(function() {
                    content.append(modules[module].element);
                    $('head [data-css="headCSS"]').append(modules[module].headCSS);
                    addEditModuleButtons($('#main .module'));
                    $('#addModule').modal('hide');
                    content.unbind('click');
                });

            });
            $main.prepend(createAlert({type:'info', title:'Select the content area to add your module too.', dismiss: true}))
                .find('.alert')
                .alert()
                .bind('closed.bs.alert', function () {
                    $('.content').removeClass('selectable').unbind('click');
                });

            $('.content').addClass('selectable').click(function() {
                content = $(this);
                $('.content').unbind('click'); // not sure this is right??
                $('#addModule').modal('show');
                $('.content').removeClass('selectable');
                $main.find('.alert').alert('close');
            });

        } else {
            $main.prepend(createAlert({type:'error', title:'You must add a content container first!', dismiss:true}))
                .find('.alert')
                .alert();
        }
    });

    $('#edit-layout [name="layout-colour"]').change(function() {
        $main.css('background-color', getColor($(this).spectrum("get")));
    });

    $('#edit-layout [name="container-colour"]').change(function() {
        $main.find('.container').css('background-color', getColor($(this).spectrum("get")));
    });

    $('#edit-layout [name="ectrumgetcol"]')
    .click(function(e) {
        e.preventDefault();
        var $this = $(this);
        window.KCFinder = {
            callBack: function(url) {
                $this.val(url);
                window.KCFinder = null;
				$this.trigger('change');
            }
        };
        window.open('/orbit-admin/media/kcfinder/browse.php?type=files', 'kcfinder_single', 'status=0, toolbar=0, location=0, menubar=0, directories=0, ' + 
'resizable=1, scrollbars=0, width=800, height=600');
    }).change(function() {
        var value = $(this).val();
		$('.background-accordion #background .bg-settings').remove();
		if (value.length > 0) {
			
        	$main.css('ectrumgetcol', 'url("' + value + '")');
        	request.background = $main.css('background');
			
			$('#backgroundModal').load('/orbit-admin/includes/modals/backgroundModal.php', function() {
				
				var bgsettings = '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#backgroundModal">Edit background settings</button>';
				$('.background-accordion #background').append('<div class="form-group bg-settings">' + bgsettings + '</div>');
				
				$('#backgroundModal').modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
	
				$('#backgroundModal [name="position"]').change(function() {
					$main.css('background-position', $(this).val());
				});
	
				$('#backgroundModal [name="repeat-x"]').change(function() {
					if ($(this).is(':checked') && $('#backgroundModal [name="repeat-y"]').is(':checked')) {
						$main.css('background-repeat', 'repeat');
					} else if ($(this).is(':checked')) {
						$main.css('background-repeat', 'repeat-x');
					} else if ($('#backgroundModal [name="repeat-y"]').is(':checked')) {
						$main.css('background-repeat', 'repeat-y');
					} else {
						$main.css('background-repeat', 'no-repeat');
					}
				});
	
				$('#backgroundModal [name="repeat-y"]').change(function() {
					if ($(this).is(':checked') && $('#backgroundModal [name="repeat-x"]').is(':checked')) {
						$main.css('background-repeat', 'repeat');
					} else if ($(this).is(':checked')) {
						$main.css('background-repeat', 'repeat-y');
					} else if ($('#backgroundModal [name="repeat-x"]').is(':checked')) {
						$main.css('background-repeat', 'repeat-x');
					} else {
						$main.css('background-repeat', 'no-repeat');
					}
				});
	
				$('#backgroundModal [data-action="save"]').click(function() {
					$('#backgroundModal').modal('hide');
					// we dont need to do anything!? leaving this here in case
				});
			});
		}
    });

    $('#edit-layout [name="container-image"]')
    .click(function(e) {
        e.preventDefault();
        var $this = $(this);
        window.KCFinder = {
            callBack: function(url) {
                $this.val(url);
                window.KCFinder = null;
				$this.trigger('change');
            }
        };
        window.open('/orbit-admin/media/kcfinder/browse.php?type=files', 'kcfinder_single', 'status=0, toolbar=0, location=0, menubar=0, directories=0, ' + 
'resizable=1, scrollbars=0, width=800, height=600');
    }).change(function() {
        var value = $(this).val();
		$('#container .container-color .bg-settings').remove();
		if (value.length > 0) {
			
			$main.find('.container').css('ectrumgetcol', 'url("' + value + '")');
			$('#containerModal').load('/orbit-admin/includes/modals/backgroundModal.php', function() {
				
				var bgsettings = '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#containerModal">Edit background settings</button>';
				$('#container .container-color').append('<div class="form-group bg-settings">' + bgsettings + '</div>');
				
				$('#containerModal').modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
	
				$('#containerModal [name="position"]').change(function() {
					$main.find('.container').css('background-position', $(this).val());
				});
	
				$('#containerModal [name="repeat-x"]').change(function() {
					if ($(this).is(':checked') && $('#containerModal [name="repeat-y"]').is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat');
					} else if ($(this).is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat-x');
					} else if ($('#containerModal [name="repeat-y"]').is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat-y');
					} else {
						$main.find('.container').css('background-repeat', 'no-repeat');
					}
				});
	
				$('#containerModal [name="repeat-y"]').change(function() {
					if ($(this).is(':checked') && $('#containerModal [name="repeat-x"]').is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat');
					} else if ($(this).is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat-y');
					} else if ($('#containerModal [name="repeat-x"]').is(':checked')) {
						$main.find('.container').css('background-repeat', 'repeat-x');
					} else {
						$main.find('.container').css('background-repeat', 'no-repeat');
					}
				});
	
				$('#containerModal [data-action="save"]').click(function() {
					$('#containerModal').modal('hide');
					// we dont need to do anything!? leaving this here in case
				});
			});
		}
    });

    $('#edit-layout [data-action="preview"]').click(function(e) {
	e.preventDefault();
	var form = $('<form action="/orbit-admin/preview/" method="POST" target="_blank"></form>');
	
        var content = $('#main').clone();
        content.find('.ui-sortable').removeClass('ui-sortable');
        content.find('.editable').removeClass('editable');
        content.find('.actions').remove();
        content = content.html();

	var input = $('<input type="hidden" name="preview">').val(content);
	form.append(input);
        input = $('<input type="hidden" name="pageName">').val($('input[name="name"]').val());
        form.append(input);
        input = $('<input type="hidden" name="background-color">').val($('#edit-layout [name="layout-colour"]').val());
	form.append(input);
        input = $('<input type="hidden" name="headcss">').val($('head [data-css="headCSS"]').html());
	form.append(input);
	$('body').append(form);
        form.submit();
        form.remove();
    });

    $('#edit-layout form').on('submit autosave', function(event) {
        event.preventDefault();
        var eventName = event.type;
        var content = $('#main').clone();
        content.find('.ui-sortable').removeClass('ui-sortable');
        content.find('.editable').removeClass('editable');
        content.find('.actions').remove();
        content = content.html();

        request.content     = content;
        request.head        = $('head [data-css="headCSS"]').html();
        request.js          = $('#edit-layout [name="script"]').val();
        request.background  = $main.css('background') || $main.css("background-color") + ' ' + $main.css("background-image") + ' ' + $main.css("background-repeat") + ' ' + $main.css("background-position");
        request.name        = $('#edit-layout [name="name"]').val();
        request.container   = $('#edit-layout [name="container"]').is(':checked');
        request.homepage = $('#edit-layout [name="homepage"]').is(':checked');
        if (typeof lID != 'undefined') request.id = lID;
		request.active = true;
		if(eventName == 'autosave') request.active = false;

 		$.ajax({
			type: "POST",
			url: "/orbit-admin/layouts/save.php",
			data: request,
			success: function(data, textStatus, jqXHR) {
				try{
					$result = $.parseJSON(data);
				} catch(error){
					$result = {code:502, message: 'Save failed. Layout name already exists. Error code: 502'};
				}
				if ($result.code == 200) {
				    var successAlert = createAlert({type: 'success', title: $result.message});
					window.location.hash = "/success";
					$('#builder').trigger('save-success', $result.id);
					$('#notifications').append(successAlert);
					successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
                    successAlert.show();
				} else {
					var failAlert = createAlert({type:'error', title: $result.message});
					window.location.hash = "/error";
					$('#builder').trigger('save-fail');
					$('#notifications').append(failAlert);
                    failAlert.show();
					failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
				}
            },
			error: function(data) {
				var failAlert = createAlert({type:'error', title: "Save failed. Unknown Error"});
				window.location.hash = "/error";
				$('#builder').trigger('save-fail');
				$('#notifications').append(failAlert);
				failAlert.show();
				failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });	
			},
  			cache: false
    	});
    });  

});