
<div id="calculate-velocity">
	<form v-on:submit.prevent="calculateVelocity">
		<p class="intro"><span>Enter your sprint scores (comma separated):</span> <input type="text" size="50" ref="sprint_scores" /> <button v-on:click="calculateVelocity" id="calculate-velocity">Calculate velocity</button></p>
		<div v-html="content">Please enable Javascript...</div>
		<div id="chart"></div>
	</form>
</div>

<div id="feedback">
    <hr />
    <span>Tell us what you think about this tool. Is it helpful? What features should we add next?</span>
    <form method="post" action="/submit-feedback">
        <textarea name="feedback"></textarea><br />
        <button><img src="/images/feedback.png" alt="icon" /> <span>Send feedback</span></button>
    </form>
</div>