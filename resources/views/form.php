
<div id="calculate-velocity">
	<p><span>Enter your sprint scores here:</span> <input type="text" size="50" ref="sprint_scores" /> <span>(comma separated)</span></p>
	
	<button v-on:click="calculateVelocity" id="calculate-velocity">Calculate velocity</button>

	<div v-html="content">Please enable Javascript...</div>
</div>