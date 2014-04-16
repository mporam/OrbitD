var editModules = function() {
	$('#main.ui-sortable').sortable("destroy");
	$('.content .actions').remove();

	$('.module').each(function() {

		$(this)
			.addClass('editable')
			.prepend("<div class='actions'><a href='#' class='btn btn-danger delete'>Delete</a><a href='#' class='btn btn-info offset'>Offset</a><a href='#' class='btn btn-info edit'>Edit</a></div>")
			.on('click', '.btn.edit', function(e) {
				e.preventDefault();
				// window.location.href = *get the module ID and direct there*
				// this should direct to the module section
			}).on('click', '.btn.offset', function(e) {
				e.preventDefault();
				$('#offsetModal').modal('show');
				offset = $(this).parents('.module').first();
			}).on('click', '.btn.delete', function(e) {
				e.preventDefault();
				$(this).parents('.editable').first().remove();
			});
	});

	$(".content").removeClass('editable').sortable({
		placeholder: "drop-target",
		items: '.module',
		start: function(e, ui) {
			var height = (ui.item.height() - 2); // -2 accounts for the border on the placeholder
            ui.placeholder.height(height).addClass(ui.item.attr('class'));
		}
	});
};

var editContent = function() {
	$('.module').removeClass('editable');
	$('.module .actions').remove();
	$(".content.ui-sortable").sortable("destroy");

	$(".content")
		.each(function() {

			$(this)
				.addClass('editable')
				.prepend("<div class='actions'><a href='#' class='btn btn-danger delete'>Delete</a><a href='#' class='btn btn-info edit'>Edit</a></div>")
				.on('click', '.btn.edit', function(e) {
					// open a box with settings for that content such as fixed position
				})
				.on('click', '.btn.delete', function(e) {
					e.preventDefault();
					$(this).parents('.editable').first().remove();
				});
		});

	$("#main").sortable({
		placeholder: "drop-target",
		items: '.content',
		start: function(e, ui) {
			var height = (ui.item.height() - 2); // -2 accounts for the border on the placeholder
            ui.placeholder.height(height).addClass(ui.item.attr('class'));
		}
	});
};

var createLayout = function(layout, container) {

	if (container) {
		$main.html($container.html(layouts[layout]));
	} else {
		$main.html(layouts[layout]);
	}

};

var $container = $('<div class="container"></div>'),
	layouts = {},
	request = {},
	modules = {},
	layout, container, module, content, offset;
	layouts['blank'] = '';
	layouts['default'] = $('<div class="editable content col-lg-12"></div><div class="editable content col-lg-12"></div><div class="editable content col-lg-12"></div>');
	layouts['sidebarL'] = $('<div id="sidebar" class="editable content col-xs-6 col-sm-3 sidebar-offcanvas"></div><div class="editable col-xs-12 col-sm-9 content"></div>');
	layouts['sidebarR'] = $('<div class="editable col-xs-12 col-sm-9 content"></div><div id="sidebar" class="editable content col-xs-6 col-sm-3 sidebar-offcanvas"></div>');
	layouts['twocol'] = $('<div class="editable content col-lg-6"></div><div class="editable content col-lg-6"></div>');
	layouts['threecol'] = $('<div class="editable content col-lg-4"></div><div class="editable content col-lg-4"></div><div class="editable content col-lg-4"></div>');
	// store layouts in db

	modules['jumbatron'] = '<div class="jumbotron module"><div class="container"><h1>Hello, world!</h1><p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p><p><a class="btn btn-primary btn-lg">Learn more &Gt;</a></p></div></div>';
	modules['module-1']  = '<div class="module col-lg-4"><h2>Heading 1</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p><p><a href="#" class="btn btn-default">View details &Gt;</a></p></div>';
	modules['module-2']  = '<div class="module col-lg-4"><h2>Heading 2</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p><p><a href="#" class="btn btn-default">View details &Gt;</a></p></div>';
	modules['module-3']  = '<div class="module col-lg-4"><h2>Heading 3</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p><p><a href="#" class="btn btn-default">View details &Gt;</a></p></div>';
	modules['footer']    = '<footer class="module"><p>&copy; Company 2013</p></footer>';
	// these should be generated from modules db.table

$(function() {

	$main = $('#main');

	$('a[data-action="layout-choice"]').click(function(e) {
		e.preventDefault();
		$('#layoutChoice .modal-body').prepend('<div class="alert alert-danger">Changing layout will remove all current layout containers!</div>');
		$('#layoutChoice').modal('show');
	});

	$('#edit-layout [name="container"]').change(function() {
		var html;
		if ($(this).is(':checked')) {
			html = $main.html();
			$main.html($container.html(html));
		} else {
			html = $container.html();
			$main.html(html);
		}
	});

	$('#layoutChoice [name="container"]').change(function() {
		$('#layoutChoice .modal-body .center').toggleClass('container-layout');
		$('#edit-layout [name="container"]').attr('checked', 'checked');
	});

	$('#layoutChoice .modal-body .btn').click(function() {
		$('#layoutChoice .btn.active').removeClass('active');
		$(this).addClass('active');
		$('#layoutChoice [data-action="save"]').prop("disabled", false);
	});

	$('#layoutChoice [data-action="save"]').click(function() {
		layout = $('#layoutChoice .modal-body .active').attr('data-name');
		container = $('#layoutChoice .modal-body .center').hasClass('container-layout');
		createLayout(layout, container);
		$('#layoutChoice').modal('hide');
	});

	$('#layoutChoice').modal('show');

	editContent();

	$('#editSettings a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	}).on('shown.bs.tab', function (e) {
		if ($(e.target).attr('href') == '#module') {
			editModules();
		} else {
			editContent();
		}
	});

	$('a[data-action="select-module"]').click(function(e) {
		e.preventDefault();
		$main.prepend($('<div class="alert alert-info">Select the content area to add your module too.</div>')).find('.alert').alert();
		$('.content').addClass('selectable').click(function() {
			content = $(this);
			// need to unbind click event here!!
			$('#addModule').modal('show');
			$('.content').removeClass('selectable');
			$main.find('.alert').alert('close');
		});
	});

	$('#addModule .list-group-item').click(function(e) {
		e.preventDefault();
		$(this).parent().find('.active').removeClass('active');
		$(this).addClass('active');
		$('#addModule [data-action="add-module"]').prop("disabled", false);

		module = $(this).attr('href');
		$('#addModule #preview .panel-body').html(modules[module]);
	});

	$('#addModule [data-action="add-module"]').click(function() {
		content.append(modules[module]);
		$('#addModule').modal('hide');
	});

	$('#edit-layout [name="layout-colour"]').change(function() {
		$main.css('background-color', $(this).val());
	});

	$('#offsetModal [data-action="add-offset"]').click(function() {
		offset.find('.badge').remove();
		offset
			.addClass('col-lg-offset-' + $('#offsetModal select').val())
			.find('.btn.offset')
			.append('<span class="badge">' + $('#offsetModal select').val() + '</span>');
		$('#offsetModal').modal('hide')
	});

	$('#edit-layout [name="container"]').change(function() {
		var html
		if ($(this).is(':checked')) {
			 html = $main.html();
			$main.html($container.html(html));
			$('#layoutChoice [name="container"]').attr('checked', 'checked');
		} else {
			$('#layoutChoice [name="container"]').attr('checked', false);
			html = $container.html();
			$main.html(html);
		}
	});


	$('#edit-layout [data-action="preview"]').click(function() {
		var previewForm = document.createElement("form");
			previewForm.target = "_blank";
			previewForm.method = "POST"; // or "post" if appropriate
			previewForm.action = "preview";

			var previewInput = document.createElement("input");
			previewInput.type = "text";
			previewInput.name = "html";
			previewInput.value = $main.html();
			previewForm.appendChild(previewInput);

			previewInput = document.createElement("input");
			previewInput.type = "text";
			previewInput.name = "name";
			previewInput.value = $('#edit-layout [name="name"]').val();
			previewForm.appendChild(previewInput);

			document.body.appendChild(previewForm);
			previewForm.submit(); // need to check this works!!
	});

	$('#edit-layout form').submit(function(e) {
		e.preventDefault();
		var content = $('#main .content').clone();
		content.find('*').remove();
		content = $('<div>').append(content).html();

		request.content     = content;
		request.background  = $('#edit-layout [name="layout-colour"]').val();
		request.name        = $('#edit-layout [name="name"]').val();
		request.container   = $('#edit-layout [name="container"]').is(':checked');

		console.log(request);

//		$.post({
//			url: "#",
//			data: request,
//			success: function() {
//				alert('win!');
//			}
//		}).done(function() {
//			alert('done...apparently?');
//		});
	});

});