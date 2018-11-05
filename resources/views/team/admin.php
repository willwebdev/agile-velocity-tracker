
<h1><?php echo $team_name; ?></h1>

<script type="text/javascript">
    window.avt = window.avt || {};
    window.avt.team = window.avt.team || {};
    window.avt.team.id = "<?php echo $team_id; ?>";
    window.avt.team.adminToken = "<?php echo $admin_token; ?>";
    window.avt.team.scores = [<?php echo implode(",", $scores); ?>];
</script>

<div id="calculate-velocity">
    <form v-on:submit.prevent="calculateVelocity">
        <p class="intro"><span>Enter your sprint scores (comma separated):</span> <input type="text" size="50" ref="sprint_scores" /> <button v-on:click="calculateVelocity" id="calculate-velocity">Calculate velocity</button></p>
        <div v-html="content">Please enable Javascript...</div>
        <div id="chart-velocityavg" class="chart"></div>
        <br />
        <div id="chart-burnup" class="chart"></div>
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