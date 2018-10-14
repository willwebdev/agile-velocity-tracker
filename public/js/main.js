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
				this.content = "<p>Avg: " + response.body.average + " / Var: " + response.body.variance + "</p>" +
								"<p>Min: " + response.body.min + " / Max: " + response.body.max + "</p>";

				var latestScores = allScores.slice(-6);
				var target = document.getElementById('chart');
				var xVals = [1,2,3,4,5,6,7,8,9,10,11,12];
				var trace1 = {
					x: xVals,
					y: latestScores
				};
				var trace2 = {
					x: xVals,
					y: Array(latestScores.length - 1).fill(null).concat([]) // prediction line... TBC
				};
				var data = [trace1,trace2];
				var layout = {
					title: 'Your velocity',
				};
				var opts = { staticPlot: true };
				Plotly.plot(target, data, layout, opts);
            });
		}
	}
});