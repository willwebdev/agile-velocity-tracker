
<div id="calculate-velocity">
	<form v-on:submit.prevent="calculateVelocity">
		<p><span>Enter your sprint scores (comma separated):</span> <input type="text" size="50" ref="sprint_scores" /> <button v-on:click="calculateVelocity" id="calculate-velocity">Calculate velocity</button></p>
		<div v-html="content">Please enable Javascript...</div>
		<div id="chart"></div>
	</form>
</div>