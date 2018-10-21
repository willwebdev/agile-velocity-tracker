var vmHome = new Vue({
	el: '#calculate-velocity',
	data: {
		content: null
	},
	created() {
		this.content = "";
	},
	methods: {
		calculateVelocity: function() {
			var allScores = this.$refs.sprint_scores.value.split(",");
			this.$http.post('/calculate-velocity', {scores: allScores}).then(response => {
				this.content = "<p class=\"velocity-report\">"
				+ "<b>Velocity avg</b>: <span class=\"avg\">" + Math.round(response.body.average) + "</span> (variance range of "
				+ "<span class=\"lower\">" + Math.round(response.body.average - response.body.variance) + "</span> to "
				+ "<span class=\"upper\">" + Math.round(response.body.average + response.body.variance) + "</span>)"
				+ "</p>";

				var latestScores = allScores.slice(-6);
				var target = document.getElementById('chart');
				var xVals = [1,2,3,4,5,6,7,8,9,10,11,12];

				var traceScores = {
					name: "Sprint scores",
					x: xVals,
					y: latestScores,
					line: {
						color: "#f93"
					}
				};
				var traceAverage = {
					name: "Velocity (mean avg)",
					x: xVals,
					y: Array(latestScores.length).fill(response.body.average),
					line: {
						dash: "dot",
						color: "#06c"
					},
					mode: "lines"
				};
				var traceVariationLow = {
					name: "Lower variance",
					x: xVals,
					y: Array(latestScores.length).fill(response.body.average - response.body.variance),
					line: {
						dash: "dot",
						color: "#900"
					},
					mode: "lines"
				};
				var traceVariationHigh = {
					name: "Upper variance",
					x: xVals,
					y: Array(latestScores.length).fill(response.body.average + response.body.variance),
					line: {
						dash: "dot",
						color: "#090"
					},
					mode: "lines"
				};
				var data = [traceScores, traceAverage, traceVariationLow, traceVariationHigh];

				var range = (response.body.max - response.body.min) *1.5; // bit of padding
				var layout = {
					title: 'Most recent 6 sprints',
					yaxis: {
						range: [response.body.average - range, response.body.average + range]
					},
					legend: {
						orientation: "h"
					},
					margin: {
						t: 60,
						l: 45,
						r: 30
					}
				};
				var opts = {
					staticPlot: true,
					responsive: true
				};
				Plotly.react(target, data, layout, opts);
            });
		}
	}
});