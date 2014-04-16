var types = {},
	$el,
	request = {};
	types['navigation'] = $('<nav class="navbar navbar-default">Example</nav>');
	types['header'] = $('<div class="jumbotron">Example</div>');
	types['custom'] = $('<div>Example</div>');
	types['carousel'] = $('<div id="carousel" class="carousel slide"><ol class="carousel-indicators"></li></ol><div class="carousel-inner"></div></div><script>$(function() {$(".carousel").carousel();});</script>');
	types['footer'] = $('<footer>Example</footer>');
	// these should be stored in the db

var carouselModal = function() {
	$('#carouselModal .step').hide().filter('#step1').show();
	$('#carouselModal').modal('show');

	$('#carouselModal').find('.btn-next').click(function() {
		$('#carouselModal .step').hide();
		$('#carouselModal').find('#step' + $(this).attr('data-step')).show();
		if ('step' + $(this).attr('data-step') == $('#carouselModal .step').last().attr('id')) {
			$('#carouselModal .btn-primary').prop('disabled', false).click(function() {
				// use all the settings in the carousel, this is going to be horrible to write, so i will do it later
				$('#carouselModal').modal('hide');
			});
		}
	});

	$('#carouselModal #slides').on('click', '.glyphicon-plus', function() {
		$('#carouselModal .slide').last().clone().appendTo('#carouselModal #slides');
	});

	$('#carouselModal #slides').on('click', '.glyphicon-minus', function() {
		$(this).parents('.slide').first().remove();
	});

};

var navModal = function() {
	$('#navModal .step').hide().filter('#step1').show();
	$('#navModal').modal('show');

	$('#navModal').find('.btn-next').click(function() {
		$('#navModal .step').hide();
		$('#navModal').find('#step' + $(this).attr('data-step')).show();
		if ('step' + $(this).attr('data-step') == $('#navModal .step').last().attr('id')) {
			$('#navModal .btn-primary').prop('disabled', false).click(function() {
				// use all the settings in the nav, this is going to be horrible to write, so i will do it later
				$('#navModal').modal('hide');
			});
		}
	});
	//not really looking forward to writting this but either
};

$(function() {

CKEDITOR.replace('moduleContent');

	var editContent = function($el) {
		$('#contentModal').modal('show');

		$('#contentModal [data-action="save"]').click(function() {
			$el.html(CKEDITOR.instances.moduleContent.getData());
			$('#contentModal').modal('hide');
		});
	};

	$('#new-module [name="name"]').change(function() {
		request.name = $(this).val();
	});

	$('#new-module [name="type"]').change(function() {
		var val = $(this).val();
		if (val == 'navigation') {
			navModal();
		};
		if (val == 'carousel') {
			carouselModal();
		};
		$('#main').html(types[val]);
		$el = $('#main').find('> *').not('script, style');
		$el.addClass('module');
		request.type = val;

		$('#new-module [type="color"][name="background"]').spectrum("set", $el.css('background-color'));

		$el.click(function() { editContent($el)});
		$('.btn-edit').click(function() { editContent($el)});
	});

	$('#new-module [name="size"]').change(function() {
		$el.removeClass (function (index, css) {
			return (css.match (/\bcol-lg-\S+/g) || []).join(' ');
		}).addClass('col-lg-' + $(this).val());
	});

	$('#new-module [name="background"]').change(function() {
		if ($(this).val() !== 'none') {
			$('[type="checkbox"][name="background"]').prop('checked', false);
		}
		$el.css('background', $(this).val());
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
	});

	$('#new-module [name="padding"]').change(function() {
		$el.css('padding', $(this).val());
	});

	$('#new-module').submit(function(e) {
		e.preventDefault();
		request.css     = $el.attr('style');
		request.classes = $el.attr('class');
		request.content = $el.html();

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