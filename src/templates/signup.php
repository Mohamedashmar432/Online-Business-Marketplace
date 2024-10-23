<?php
$client_id=config::get_config('google_oauth.client_id');
$client_secret = config::get_config('google_oauth.client_secret');
$redirect_uri = config::get_config('google_oauth.redirect_uri');
$captcha_id=config::get_config('recaptcha.id');
$captcha_secret=config::get_config('recaptcha.secret');

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('email');
$client->addScope('profile');
$signup_url = $client->createAuthUrl();
$signup = false;
$error = null;
$recaptchaSecret = $captcha_secret;
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;

    $client->setAccessToken($token['access_token']);

    // Get user profile info from Google
    $google_service = new Google_Service_Oauth2($client);
    $data = $google_service->userinfo->get();

    // Store user details in session or database



    $name = explode(' ', $data['name'], 2);
    $pass = md5($data['name']);
    $signup = auth::signup($name[0], $name[1], $data['email'], '0', $pass, $data['id']);
    if ($signup == true) {
        UserSession::authenticate($data['email'], $pass);
?>
        <script>
            window.location.href = "/index.php";
        </script>
    <?php
    } else {
    ?>
        <script>
            window.location.href = "/signup.php";
        </script>
        <?php
        $error = 'google auth failed for some reason please try by manual';
    }

    exit();
}


if ($recaptchaResponse) {
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($verifyUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
    $responseData = json_decode($response);

    if ($responseData->success && $responseData->score >= 0.5) { // 0.5 threshold, adjust as needed
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
                $fname = $_POST['first_name'];
                $lname = $_POST['last_name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $password = $_POST['password'];

                $signup = auth::signup($fname, $lname, $email, $phone, $password);

                if ($signup === true) { // If signup returns true, proceed
        ?>
                    <script>
                        window.location.href = "/signin.php";
                    </script>
<?php
                } else {
                    $error = $signup;
                }
            } else {
                $error = "Missing inputs";
            }
        }
    } else {
        $error = "Please verify that you're not a robot or try again later.";
    }
} else {
    $error = null;
}
?>
<section class="signup">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <div class="text-center mb-4">
                        <img src="./src/assets/brand_logo.png" alt="Logo" width="72" height="57">
                    </div>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <h2 class="text-center mb-4">Please sign up</h2>
                    <form method="POST" id="signup-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit" id="submitBtn">Sign up</button>
                        </div>
                        <div class="my-3">
                            <a class="btn btn-outline-primary w-100" href="<?= htmlspecialchars($signup_url); ?>">
                                <img src="./src/assets/google-icon.png" loading="lazy" alt="Google Logo" style="width:20px;">
                                Sign in with Google
                            </a>
                        </div>
                    </form>
                    <p class="mt-3 text-center">
                        Already have an account? <a href="signin.php">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js?render=6LfDUl0qAAAAALA3991bO-Df2Zr2QHG4zb0QeVFB"></script>
<script>
    document.getElementById('signup-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Stop the form from submitting normally

        grecaptcha.ready(function() {
            grecaptcha.execute(<?php echo $captcha_id?> , {
                action: 'submit'
            }).then(function(token) {
                // Add the token to the form
                document.getElementById('g-recaptcha-response').value = token;

                // Submit the form
                document.getElementById('signup-form').submit();
            });
        });
    });
</script>