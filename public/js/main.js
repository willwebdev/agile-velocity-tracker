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
			this.$http.post('/calculate-velocity', {scores: this.$refs.sprint_scores.value}).then(response => {
				this.content = "<p>Avg: " + response.body.average + " / Var: " + response.body.variance + "</p>";
            });
		}
	}
});