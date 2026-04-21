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
	$('.form_datetime').datetimepicker({
			sideBySide: true,
			viewDate : false,
			format: 'Y-MM-DD H:m:s',
			minDate:new Date()
	});
	$('.form-date-hidden').datetimepicker({
			sideBySide: true,
			viewDate : false,
			format: 'Y-MM-DD H:m:s',
			minDate:new Date()
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
    /* var filename=document.getElementById('upload').value;
	var filesize = document.getElementById('upload');
	console.log(filesize.files[0].size);
    var extension=filename.substr(filename.lastIndexOf('.')+1).toLowerCase();
    //alert(extension);
    if(extension=='jpg' || extension=='gif' || extension=='png' || extension=='txt' || extension=='pdf'  || extension=='docx') {
		 if ( filesize > maxfilesize )
		{
			alert('File Size is more than 1 MB!');
			return false;
		}
		else
		{
			return true;
		}
    } else 
	{
        alert('Not Allowed Extension!.Only allowed files is (gif,jpg,png,txt,pdf,docx)');
		return false;
    } */
}