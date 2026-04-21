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
	    		total_tickets = json_data.total_tickets;
  				data.push({"label" :name , "data" : total_tickets}) ;
			});
		var placeholder = $("#placeholder");

		placeholder.unbind();
		$.plot(placeholder, data, {
			series: {
				pie: { 
					show: true,
					combine: {
						color: "#999",
						threshold: 0.05
					}
				}
			},
			legend: {
				show: false
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
function labelFormatter(label, series) {
	return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
}
//

function setCode(lines) {
	$("#code").text(lines.join("\n"));
}
