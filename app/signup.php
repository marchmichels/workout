<?php
/**
 * Description: the sign-in form
 */
?>
<!--------- signup form ----------------------------------------------------------->
<form class="form-signup" style="display: none">
    <!--<input type="hidden" name="form-name" value="signup">-->
    <h1 class="h3 mb-3 font-weight-normal" style="padding: 20px; color: #FFFFFF; background-color: #6c757d">Create an account at Kettlebell Fitness</h1>
    <div style="width: 250px; margin: auto">


        <label for="username" class="sr-only">Username</label>
        <input type="text" id="signup-username" class="form-control" placeholder="Username" required autofocus>

        <label for="password" class="sr-only">Password</label>
        <input type="password" id="signup-password" class="form-control" placeholder="Password" required>

        <label for="first_name" class="sr-only">First Name</label>
        <input type="text" id="signup-first-name" class="form-control" placeholder="First Name" required>

        <label for="last_name" class="sr-only">Last Name</label>
        <input type="text" id="signup-last-name" class="form-control" placeholder="Last Name" required>

        <label for="street_address" class="sr-only">Street Address</label>
        <input type="text" id="signup-street-address" class="form-control" placeholder="Street Address" required>

        <label for="city" class="sr-only">City</label>
        <input type="text" id="signup-city" class="form-control" placeholder="City" required>

        <label for="state" class="sr-only">State</label>
        <input type="text" id="signup-state" class="form-control" placeholder="State" required>

        <label for="zipcode" class="sr-only">Zipcode</label>
        <input type="text" id="signup-zipcode" class="form-control" placeholder="Zipcode" required>

        <button class="btn btn-lg btn-secondary btn-block" type="submit">Sign up</button>
        <div class="img-loading-container">
            <div class="img-loading">
                <img src="img/loading.gif">
            </div>
        </div>
        <p style="padding-top: 10px;">Already have an account? <a id="mychatter-signin" href="#signin">Sign in</a></p>
    </div>
</form>
