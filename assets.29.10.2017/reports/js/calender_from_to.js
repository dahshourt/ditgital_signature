$(function () {
	$('#created_from').datetimepicker({
		sideBySide: true,
		viewDate : false,
		format: 'Y-MM-DD H:m:s',
	});
	$('#created_to').datetimepicker({
		sideBySide: true,
		viewDate : false,
		format: 'Y-MM-DD H:m:s',
	});
});