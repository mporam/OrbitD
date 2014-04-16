<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');         
	
	$query = $con->prepare("SELECT * FROM layout");
	$query -> execute();
	$layouts = $query->fetchAll(PDO::FETCH_ASSOC);
?>
		
<script>
$('#builder').off('layoutSave');
$('#builder').on('layoutSave', function() {
        infoAlert.remove();
	if (success == loop) {
		var successAlert = createAlert({type:'success', title: 'Updated layouts'});
		$('#notifications').append(successAlert);
		successAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		successAlert.show();
	} else {
	    var failAlert = createAlert({type:'error', title: 'Failed to update all layouts. Please try again.'});
		$('#notifications').append(failAlert);
		failAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		failAlert.show();	
	}
});

var module = request;
var layouts = <?php echo json_encode($layouts); ?>;
var name = module.oldName.replace(" ","-");

var layoutContent, element, success = 0, fail = 0, loop = 0, count = layouts.length;

var infoAlert = createAlert({type:'info', title: 'Updating layouts&hellip;'});
$('#notifications').append(infoAlert);
infoAlert.show();

layouts.forEach(function(layout) {
	layoutContent = $(layout.content);
	
	if (layoutContent.find('#' + name).length > 0) {
		loop++;
		element = module.element;
		layoutContent.find('#' + name).replaceWith(element);
		layoutContent = $('<div>').append(layoutContent).html();
		layout.content = layoutContent;

		$.ajax({
			type: "POST",
			url: "/orbit-admin/layouts/save.php",
			data: layout,
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
				if (count == 0) $('#builder').trigger('layoutSave');
			},
			error: function() {
				count--;
				fail++;
				if (count == 0) $('#builder').trigger('layoutSave');
			},
			cache: false
		});
	} else {
		count--;
		if (count == 0 && (success > 0 || fail > 0)) {
			$('#builder').trigger('layoutSave');
		} else if (count == 0) {
			infoAlert.find('strong').text('No layouts to update');
			infoAlert.delay(3000).fadeOut(1000, function() { $(this).remove(); });
		}
	}
});
</script>