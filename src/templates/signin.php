
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
$signin_url = $client->createAuthUrl();
$error = null; // Initialize error variable


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
    $signin =  UserSession::authenticate($data['email'], $pass);
    if ($signup == true) {
?>
        <script>
            window.location.href = "/index.php";
        </script>
    <?php
    } else {
    ?>
        <script>
            window.location.href = "/signin.php";
        </script>
        <?php
        $error = 'google auth failed for some reason please try by manual';
    }

    exit();
}


if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaRequired = $_SESSION['login_attempts'] >= 3; // Require reCAPTCHA after 3 failed attempts

    if ($recaptchaRequired) {
        // Verify reCAPTCHA if the user has failed 3 times
        $recaptchaSecret = $captcha_secret;
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseData = json_decode($response);

        // If reCAPTCHA fails
        if (!$responseData->success) {
            $error = "Please verify that you're not a robot.";
            // Do not proceed further
        }
    }

    if (!$error && isset($_POST['email']) && isset($_POST['password'])) {
        // Sanitize and validate the email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password']; // Passwords should be hashed, no need for sanitization

        // Check if email is valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Attempt sign-in
            try {
                $signin = UserSession::authenticate($email, $password);
                if ($signin) {
                    // Reset login attempts on success
                    $_SESSION['login_attempts'] = 0;
                    if (isset($_SESSION['_redirect'])) {
                        header("Location: {$_SESSION['_redirect']}");
                    } else {
                        header("Location: /index.php");
                        exit;
                    }
                } else {
                    // Invalid credentials, increment login attempts
                    $_SESSION['login_attempts'] += 1;
                    $error = 'Invalid email or password';
                }
            } catch (Exception $e) {
                // Handle exceptions in authenticate()
                $_SESSION['login_attempts'] += 1;
                $error = $e->getMessage();
            }
        } else {
            // Invalid email
            $error = 'Please enter a valid email address';
        }
    } else {
        $error = "Both email and password are required";
    }
}
?>

<section class="signin">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <div class="text-center mb-4">
                        <img src="./src/assets/brand_logo.png" alt="Logo" width="72" height="57">
                    </div>

                    <!-- Display error message if set -->
                    <?php if ($error) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <h2 class="text-center mb-4">Please sign in</h2>

                    <form method="POST" id="signin-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Show reCAPTCHA after 3 failed attempts -->
                        <?php if ($_SESSION['login_attempts'] >= 3) { ?>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <?php } ?>

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Sign in</button>
                        </div>
                        <div class="my-3">
                        <a class="btn btn-outline-primary w-100" href="<?= htmlspecialchars($signin_url); ?>">
                                <img src="./src/assets/google-icon.png" loading="lazy" alt="Google Logo" style="width:20px;">
                                Sign in with Google
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- reCAPTCHA v3 Script -->
<?php if ($_SESSION['login_attempts'] >= 3) { ?>
<script src="https://www.google.com/recaptcha/api.js?render=6LfDUl0qAAAAALA3991bO-Df2Zr2QHG4zb0QeVFB"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?php echo $captcha_id;?>', { action: 'signin' }).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
</script>
<?php } ?>
