
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
        <div v-html="content">Please enable Javascript...</div>

        <div class="tabs">
            <ul>
                <li><a href="#tab-data" class="active">Enter data</a></li>
                <li><a href="#tab-velocity">Velocity graph</a></li>
                <li><a href="#tab-burn-up">Burn-up graph</a></li>
            </ul>
            <div id="tab-data" class="tab" style="display:block;">
                <p>Enter your sprint scores (comma separated): <br /><input type="text" ref="sprint_scores" size="50%" /> <button v-on:click="calculateVelocity" id="calculate-velocity">Calculate velocity</button></p>

                <div id="velocity-summary"></div>
            </div>
            <div id="tab-velocity" class="tab">
                <div id="chart-velocityavg" class="chart"></div>
            </div>
            <div id="tab-burn-up" class="tab">
                <div id="chart-burnup" class="chart"></div>
            </div>
        </div>
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

<script src="/js/tabs.js" type="text/javascript"></script>
<script>
window.addEventListener("load", function() {
    makeTabs(".tabs")
});
</script>