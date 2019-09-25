$(document).ready(function(){
	$.ajax({
		url: "http://192.168.25.40:8181/YouOn/pages/dashboard/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var dia = [];
			var valor = [];
			var meta = [];

			for(var i in data) {
				dia.push(data[i].dia);
				valor.push(data[i].valor);
				meta.push(data[i].meta);
			}

			var chartdata = {
				labels: dia,
				datasets : [
					{
						label: 'Total',
						backgroundColor: 'rgba(0, 192, 239, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						gridLinesColor: 'rgba(200, 200, 200, 0)',
						data: valor
					}, {
						label: 'Meta',
						data: meta,
						type: 'line'						
					}
				]
			};

			var options = {
				scales: {
					xAxes: [{
						gridLines: {
							display:false
						}
					}],
					yAxes: [{
						gridLines: {
							display:true
						}   
					}]
				}
			}

			var ctx = $("#vendasdia");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				options: options
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});

