<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');         
	
	$query = $con->prepare("SELECT * FROM modules WHERE type = 'navigation'");
	$query -> execute();
	$navs = $query->fetchAll(PDO::FETCH_ASSOC);
?>
		
<script>
$('#builder').off('navSave');
$('#builder').on('navSave', function() {
        infoAlert.remove();
	if (success == loop) {
                request.oldName = request.name;
		var successAlert = createAlert({type:'success', title: 'Updated Navigations'});
		$('#notifications').append(successAlert);
		successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		successAlert.show();
	} else {
	    var failAlert = createAlert({type:'error', title: 'Failed to update all navigations. Please try again.'});
		$('#notifications').append(failAlert);
		failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		failAlert.show();	
	}
});
var navs = <?php echo json_encode($navs); ?>;
var name = request.oldName.replace(/\s/g,"-");

var navContent, navElement, element, success = 0, fail = 0, loop = 0, count = navs.length;

var infoAlert = createAlert({type:'info', title: 'Updating navigations&hellip;'});
$('#notifications').append(infoAlert);
infoAlert.show();

navs.forEach(function(nav) {
	navContent = $(nav.content);
        navElement = $(nav.element);

	if (navElement.find('li[data-page="' + name + '"]').length > 0) {
                loop++;
		element = '<li data-page="' + request.name.replace(/\s/g, "-") + '"><a href="/orbit-site/?page=' + request.name.replace(/\s/g, "-") + '">' + request.name + '</a></li>';
		navContent.find('li[data-page="' + name + '"]').replaceWith(element);
                navElement.find('li[data-page="' + name + '"]').replaceWith(element);
                navContent = $('<div>').append(navContent).html();
                navElement = $('<div>').append(navElement).html();
                nav.content = navElement;
		nav.element = navElement;
                
		$.ajax({
			type: "POST",
			url: "/orbit-admin/modules/save.php",
			data: nav,
			success: function(data, textStatus, jqXHR) {
				try{
					$result = $.parseJSON(data);
				} catch(error){
					fail++;
				}
				if ($result.code == 200) {
					success++;
				} 
				count--;
				if (count == 0) $('#builder').trigger('navSave').trigger('navUpdate');
			},
			error: function() {
				count--;
				fail++;
				if (count == 0) $('#builder').trigger('navSave').trigger('navUpdate');
			},
			cache: false
		});
	} else {
		count--;
		if (count == 0 && (success > 0 || fail > 0)) {
			$('#builder').trigger('navSave').trigger('navUpdate');
		} else if (count == 0) {
                        $('#builder').trigger('navUpdate');
			infoAlert.find('strong').text('No navigations to update');
			infoAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		}
	}
});
</script>