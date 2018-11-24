var vmHome = new Vue({
	el: '#calculate-velocity',
	data: {
		content: null
	},
	created() {
		this.content = "";
	},
	mounted() {
		this.loadSprintScores();
	},
	methods: {
		loadSprintScores: function() {
			var hist = window.avt.team.scores || null;
			if (hist) {
				this.$refs.sprint_scores.value = hist;
				this.calculateVelocity();
			}
		},
		drawSummary: function(el, obj) {
			var s = "<p class=\"velocity-report\">"
				+ "<b>Velocity avg</b>: <span class=\"avg\">" + Math.round(obj.average) + "</span> " +
				"(+/- " + Math.round(obj.variance) + ", giving a velocity range of "
				+ "<span class=\"lower\">" + Math.round(obj.average - obj.variance) + "</span> to "
				+ "<span class=\"upper\">" + Math.round(obj.average + obj.variance) + "</span>)"
				+ "</p>";
			var target = document.getElementById(el);
			target.innerHTML = s;
		},
		drawVelocityAvgChart(el, scores, obj) {
			var latestScores = scores.slice(-6);
			var target = document.getElementById(el);
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
				y: Array(latestScores.length).fill(obj.average),
				line: {
					dash: "dot",
					color: "#06c"
				},
				mode: "lines"
			};
			var traceVariationLow = {
				name: "Lower variance",
				x: xVals,
				y: Array(latestScores.length).fill(obj.average - obj.variance),
				line: {
					dash: "dot",
					color: "#900"
				},
				mode: "lines"
			};
			var traceVariationHigh = {
				name: "Upper variance",
				x: xVals,
				y: Array(latestScores.length).fill(obj.average + obj.variance),
				line: {
					dash: "dot",
					color: "#090"
				},
				mode: "lines"
			};
			var data = [traceScores, traceAverage, traceVariationLow, traceVariationHigh];

			var range = (obj.max - obj.min) *1.5; // bit of padding
			var layout = {
				title: 'Most recent 6 sprints',
				yaxis: {
					range: [obj.average - range, obj.average + range]
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
		},
		drawBurnUpChart: function(el, scores, obj) {
			var target = document.getElementById(el);

			var sumScores = [];
			var total = 0;
			for (var i = 0; i < scores.length; i++) {
				total += scores[i];
				sumScores.push(total);
			}

			var traceDelivered = {
				name: "Cumulative points delivered",
				y: sumScores,
				line: {
					color: "#f93"
				}
			};

			var generateProjectionLine = function(len, base, step) {
				var blanks = Array(len).fill(null);
				var projection = Array(6).fill(1).map(function(x, i) {
					return base + (i * step);
				});
				return blanks.concat(projection);
			};

			var traceLowerBound = {
				name: "Lower projection",
				y: generateProjectionLine(scores.length - 1, total, obj.average - obj.variance),
				line: {
					dash: "dot",
					color: "#900"
				},
				mode: "lines"
			};
			var traceUpperBound = {
				name: "Upper projection",
				y: generateProjectionLine(scores.length - 1, total, obj.average + obj.variance),
				line: {
					dash: "dot",
					color: "#090"
				},
				mode: "lines"
			};
			var data = [traceDelivered, traceLowerBound, traceUpperBound];

			var layout = {
				title: 'Burn up',
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
		},
		calculateVelocity: function() {
			// split string, and convert each item to int
			var allScores = this.$refs.sprint_scores.value.split(",").map(function(x) {
				return +x;
			});

			var params = {
				scores: allScores,
				teamID: window.avt.team.id,
				adminToken: window.avt.team.adminToken
			};
			this.$http.post('/calculate-velocity', params).then(response => {
				this.drawSummary('velocity-summary', response.body);
				this.drawVelocityAvgChart('chart-velocityavg', allScores, response.body);
				this.drawBurnUpChart('chart-burnup', allScores, response.body);
            });
		}
	}
});