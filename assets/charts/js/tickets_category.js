$(function() {
	var action_name = $("#action_name").val();
	$.ajax({
		type:'POST',
	    url:action_name,
	    dataType:'JSON',
	    success:function(json){
	    	var data = [];
	    	var category_name;
	    	var total_tickets;
	    	$.each(json, function(index, json_data) {
	    		name = json_data.name;
	    		total_tickets = json_data.TOTAL_TICKETS;
  				data.push({"label" :name , "data" : total_tickets}) ;
			});
		var placeholder = $("#placeholder");

		placeholder.unbind();
		$.plot(placeholder, data, {
			series: {
				pie: { 
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 2 / 3,
						formatter: function (label, series) {
							return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent)+"%<br/>(" + series.data[0][1] +')</div>';

						},
					},
					combine: {
						color: "#999",
						threshold: 0.05
					}
				}
			},
			legend: {
				show: true
			}
		});
		setCode([
				"$.plot('#placeholder', data, {",
				"    series: {",
				"        pie: {",
				"            show: true,",
				"            combine: {",
				"                color: '#999',",
				"                threshold: 0.1",
				"            }",
				"        }",
				"    },",
				"    legend: {",
				"        show: false",
				"    }",
				"});"
			]);
	 	}
	}); 	
});

// A custom label formatter used by several of the plots
/* function labelFormatter(label, series) {
	//return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
	return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+Math.round(series.percent)+"%<br/>" + series.data[0][1] +'</div>';
} */
//

function setCode(lines) {
	$("#code").text(lines.join("\n"));
}
