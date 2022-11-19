<?php
/**
 * Author: Ran Chang
 * Date: 8/18/2019
 * File: signin.php
 * Description: the signin form
 */
?>
<!--------- signin form ----------------------------------------------------------->
<form class="form-signin" style="display: none;">
    <!--    <input type="hidden" name="form-name" value="signin">-->
    <h1 class="h3 mb-3 font-weight-normal" style="padding: 20px; color: #FFFFFF; background-color: #316AC5">Please sign in to MyChatter</h1>
    <div style="width: 250px; margin: auto">
        <label for="username" class="sr-only">Username</label>
        <input type="text" id="signin-username" class="form-control" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="signin-password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <div class="img-loading-container">
            <div class="img-loading">
                <img src="img/loading.gif">
            </div>
        </div>
        <p style="padding-top: 10px;">Don't have an account? <a id="mychatter-signup" href="#signup">Sign up</a></p>
    </div>
</form>