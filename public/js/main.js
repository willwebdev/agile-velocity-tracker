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
					}
				};
				var opts = { staticPlot: true };
				Plotly.react(target, data, layout, opts);
            });
		}
	}
});