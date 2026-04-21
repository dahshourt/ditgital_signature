$(function() {
	var action_name = $("#action_name").val();
	$.ajax({
		type:'POST',
	    url:action_name,
	    dataType:'JSON',
	    success:function(json){
	    	var data = [];
	    	$.each(json, function(index, json_data) {
  				data.push([json_data.name , json_data.total_tickets]);
			});
			$.plot("#placeholder", [ data ], {
				series: {
					bars: {
						fillColor: "#D9EDF7",
						lineWidth: 0,
						show: true,
						barWidth: 0.4,
						align: "center"
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0
				}
			});
		 }
	});
});