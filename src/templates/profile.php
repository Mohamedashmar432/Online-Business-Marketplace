
<?php
$user = $_SESSION['email'];
$profile = new auth($user); // Create auth object
$data = $profile->data;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax']) && $_POST['ajax'] == 'true') {


    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $plan = $_POST['plan'];
    $email = $_POST['email'];
    $profileData = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'phone' => $phone,
        'address' => $address,
        'plan' => $plan,
        'email' => $email,
    ];
    // Use the magic setter method to update multiple fields
    $updateStatus = $profile->setProfileUpdate($profileData); // Use correct function name for bulk setter
    if ($updateStatus) {
?> <div class="alert alert-success" id="status_success" role="alert">Your Profile updated</div><?php
                                                                                                    } else { ?>
        <div class="alert alert-danger" id="status_failed" role="alert">failed to execute your request Connection error.</div><?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?>

<section class="profile-section">
    <div class="container">
        <div class="row">

            <!-- Profile Picture Section -->
            <div class="col-lg-4 d-flex justify-content-center align-items-center" data-aos="fade-right">
                <div class="profile-picture text-center">
                    <img src="./src/assets/about-us.jpg" alt="Profile" class="profile-img">
                    <div class="status">
                        <?php if ($data['status'] == 1) {
                        ?><span class="badge bg-success">Active</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">InActive</span><?php
                                                                        }
                                                                            ?>

                    </div>
                </div>
            </div>
            <!-- Personal Info Section -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="card p-4 mb-4">
                    <h3 class="card-title text-center">Personal Information</h3>
                    <div class="row">
                        <!-- First Name and Last Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstName" value="<?php echo $data['first_name']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lastName" value="<?php echo $data['last_name']; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Email and Phone -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" value="<?php echo $data['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" value="<?php echo $data['phone']; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="<?php echo $data['address']; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Current Plan -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="currentPlan" class="form-label">Plan</label>
                                <input type="text" class="form-control" id="currentPlan" value="<?php echo $data['plan']; ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Change Details Button -->
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="changeDetailsBtn">Change Details</button>
                        <button type="button" class="btn btn-success d-none" id="saveDetailsBtn">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Sold/ Bought Section -->
        <div class="row mt-4" data-aos="fade-up">
            <div class="col-md-6">
                <div class="card p-4 mb-4">
                    <h5 class="card-title">Businesses Sold</h5>
                    <hr>
                    <!-- Business Sold Content -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 mb-4">
                    <h5 class="card-title">Businesses Bought</h5>
                    <hr>
                    <!-- Business Bought Content -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        // When the "Change Details" button is clicked
        $('#changeDetailsBtn').click(function() {
            // Enable all fields except the email field
            $('#firstName, #lastName, #phone, #address').removeAttr('readonly');

            // Hide the "Change Details" button and show the "Save Changes" button
            $('#changeDetailsBtn').addClass('d-none');
            $('#saveDetailsBtn').removeClass('d-none');
        });

        // When the "Save Changes" button is clicked
        $('#saveDetailsBtn').click(function() {
            // Collect the updated data
            let updatedData = {
                firstName: $('#firstName').val(),
                lastName: $('#lastName').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                plan: $('#currentPlan').val(),
                email: $('#email').val() // Email is still read-only but sending it along
            };

            // Send the data to the server using AJAX
            $.ajax({
                url: '/', // Update this to the URL handling profile update on your server
                type: 'POST',
                data: updatedData,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(status + error);
                }
            });

            // Disable fields after saving
            $('#firstName, #lastName, #phone, #address').attr('readonly', 'readonly');

            // Toggle buttons back to the original state
            $('#saveDetailsBtn').addClass('d-none');
            $('#changeDetailsBtn').removeClass('d-none');
        });
    });
    setTimeout(function() {
        $('#status_success').hide();
        $('#status_failed').hide();

    }, 5000);
</script>