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
    <form method="post" action="/team/new">
        <p>Welcome to the agile velocity tracker. To get started, first create your team by giving it a name.</p>
        <p><label>Team name</label> <input type="text" name="team_name" /></p>

        <p>Now enter your email address and we'll send you a special 'admin' link that you can use to manage your team's data, instead of having a password. Note: we don't store your email address and you're not subscribing to anything.</p>
        <p><label>Your email address</label> <input type="text" name="email" /></p>
        <input type="submit" value="Create team" />
    </form>
</div>