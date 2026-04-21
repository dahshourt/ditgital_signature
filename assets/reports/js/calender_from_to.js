/**
 * calender_from_to.js
 *
 * DST FIX: The datetimepicker timeZone option is set to 'Africa/Cairo'.
 * This ensures that when Egypt switches between summer time (UTC+3) and
 * winter time (UTC+2), the picker correctly reflects the local time
 * instead of a fixed browser or UTC offset.
 *
 * Requires: moment-timezone.js  (loaded alongside moment.min.js)
 * If moment-timezone is not yet included, add it before this file:
 *   bower_components/moment-timezone/builds/moment-timezone-with-data.min.js
 */
$(function () {
	$('#created_from').datetimepicker({
		sideBySide: true,
		viewDate: false,
		format: 'YYYY-MM-DD HH:mm:ss',
		timeZone: 'Africa/Cairo'
	});
	$('#created_to').datetimepicker({
		sideBySide: true,
		viewDate: false,
		format: 'YYYY-MM-DD HH:mm:ss',
		timeZone: 'Africa/Cairo'
	});
	$('.form_datetime').datetimepicker({
		sideBySide: true,
		viewDate: false,
		format: 'YYYY-MM-DD HH:mm:ss',
		minDate: new Date(),
		timeZone: 'Africa/Cairo'
	});
	$('.form-date-hidden').datetimepicker({
		sideBySide: true,
		viewDate: false,
		format: 'YYYY-MM-DD HH:mm:ss',
		minDate: new Date(),
		timeZone: 'Africa/Cairo'
	});
});


function validate() {
	// allowed extensions gif|jpg|png|txt|pdf|docx
	var maxfilesize = 1024 * 1024;
	var file_name = document.getElementsByName('upload[]');
	for(var i = 0; i< file_name.length; i++)
	{
		
		if(file_name[i].value)
		{
			var NameFile = file_name[i].files[0].name;
			var filename=file_name[i].value;
			var extension=filename.substr(filename.lastIndexOf('.')+1).toLowerCase();
			var filesize = file_name[i].files[0].size;
			if(extension=='jpg' || extension=='gif' || extension=='png' || extension=='txt' || extension=='pdf'  || extension=='docx') {
				if ( filesize > maxfilesize )
				{
					alert('File Size of name '+NameFile+' is more than 1 MB!');
					return false;
				}
			} 
			else 
			{
				alert('Not Allowed Extension of name '+NameFile+' !.Only allowed files is (gif,jpg,png,txt,pdf,docx)');
				return false;
			}
		}
		
	}
	return true;
}
