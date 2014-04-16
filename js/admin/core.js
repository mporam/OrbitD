$(function() {
    $('.expander').click(function() {
        var w = '100%';
		$(this).toggleClass('active');
		
        if ($(window).width() > '320') w = "300px";

        if ($('.sidebar').is(':visible')) {
            $('.sidebar').animate({width: '0px'}, function() {$('.sidebar').hide();}).addClass('closed').removeClass('closed');
        } else {
            $('.sidebar').show().animate({width: w}).addClass('open').removeClass('closed');
        }

    });

    $(window).resize(function() {
        if ($(window).width() >= '1000') {
            $('.sidebar').removeAttr('style');
        }
    });

    $('.admin-nav .media').click(function(e) {
        e.preventDefault();
        window.KCFinder = {
        };
        window.open('/orbit-admin/media/kcfinder/browse.php', 'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, directories=0, ' + 'resizable=1, scrollbars=0, width=800, height=600');
    });
	
	$('#modules .item-list .delete').click(function(e) {
		e.preventDefault();
		var url = this.href;
		$('#confirmDelete').load('/orbit-admin/includes/modals/confirmDeleteModule.php', function() {
			$('#confirmDelete').modal({
				backdrop: 'static',
				show: true
			});
			$('#confirmDelete .btn-danger').click(function() {
				window.location.href = url;
			});
		}); 
	});

});

//  **************** core functions

// check if object exists in array
function containsObject(obj, list) {
    var i;
    for (i = 0; i < list.length; i++) {
        if (list[i] === obj) {
            return true;
        }
    }
    return false;
}

// return object with specific key=>value from array
function searchArray(value, key, array) {

    for (var i=0; i < array.length; i++) {
        if (array[i][key] == value) {
            return array[i];
        }
    }
    return false;
}

// remove obj from array where value  = valu
function removeObject(list,prop,valu) {
	return list.filter(function (val) {
		return val[prop] !== valu;
	});
}

// create alerts - pass in {type, title, content, dismiss, class}
var createAlert = function(options) {
    if (options.length < 1) return false;
    if (typeof options.title == 'undefined') return false;
    var alert = $('<div class="alert "><strong>' + options.title + '</strong></div>');
    if (typeof options.content != 'undefined' && options.content.length > 0) alert.append(options.content);
    if (typeof options.dismiss != 'undefined' && options.dismiss) alert.prepend('<button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>');
    var alertClass = 'alert-';
    switch(options.type) {
        case 'success':
            alertClass = alertClass + 'success';
            break;
        case 'error':
            alertClass = alertClass + 'danger';
            break;
        case 'warning':
            alertClass = alertClass + 'warning';
            break;
        default:
            alertClass = alertClass + 'info';
    }
    if (typeof options.class != 'undefined' && options.class.length > 0) alertClass = alertClass + ' alert-' + options.class;
    alert.addClass(alertClass);

    return alert;
};