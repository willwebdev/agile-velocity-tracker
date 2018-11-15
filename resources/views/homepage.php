<div id="create-team">
    <?php
    if (isset($error)) {
        switch ($error) {
            case ERR_TEAM_NOT_FOUND:
                $errorMessage = "Sorry, you followed an invalid link and we couldn't find that team. Please create another one.";
                break;
            default:
                $errorMessage = "Unexpected error";
        }
        echo '<div class="error"><p>'.$errorMessage.'</p></div>';
    }
    ?>
    <div id="promo-banner">
        <div>
            <img src="/images/homepage-screenshots.jpg" width="350px" alt="Screenshots of graphs" />
        </div>
        <div>
            <ul>
                <li>Quickly record your throughput</li>
                <li>Calculate your velocity instantly</li>
                <li>Visually forecast future deliveries</li>
                <li>Free! No sign-up needed</li>
            </ul>
        </div>
    </div>
    <div id="create-team-form">
        <form method="post" action="/team/new">
            <h2>Create your team</h2>
            <p>To get started, first create your team by giving it a name.</p>
            <p>Then optionally enter your email address and we'll send you a link to manage your team. Or you can just bookmark the next page.</p>

            <p><label>Team name</label> <input type="text" name="team_name" /></p>
            <p><label>Your email address</label> <input type="text" name="email" /></p>
            <input type="submit" value="Create team" />
        </form>
    </div>
</div>