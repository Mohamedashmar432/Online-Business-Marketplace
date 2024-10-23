<?php
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['name'], $_POST['type'], $_POST['industry'], $_POST['description'], $_POST['profit'], $_POST['age'], $_POST['price'], $_POST['location'], $_FILES['file'])) {

    // Sanitize inputs to prevent XSS
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $industry = htmlspecialchars($_POST['industry']);
    $description = htmlspecialchars($_POST['description']); 
    $profit = htmlspecialchars($_POST['profit']);
    $age = htmlspecialchars($_POST['age']);
    $price = htmlspecialchars($_POST['price']); 
    $location = htmlspecialchars($_POST['location']);

    // Validate the uploaded file type and size (ensure it's an image)
    $image = $_FILES['file'];
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
    $upload_path =$_SERVER['DOCUMENT_ROOT'] . "/src/assets/business/";

    if (in_array($image['type'], $allowed_image_types) && $image['size'] < 2000000) { // 2MB size limit
      $image_tmp = $image['tmp_name'];
      $fname = md5(htmlspecialchars($_POST['name'])) . "_" . basename($image['name']);
      $image_path = $upload_path .  $fname;
      // Move the file to the target directory
      if (move_uploaded_file($image_tmp, $image_path)) {
        try {
          $seller = business::sell_business($name, $type, $industry, $description, $profit, $age, $price, $location, $fname);

          if ($seller) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?s1");
            exit();
          } else {
            echo '<div class="alert alert-danger" role="alert">Something went wrong! please try again</div>';
          }
        } catch (Exception $e) {
          $error = $e->getMessage();
          echo $error;
        }
      } else {
        $error = "Failed to upload the image.";
      }
    } else {
      $error = "Invalid image type or file size too large.";
      echo $error;
    }
  } else if (isset($_POST['phone1'], $_POST['language'])) {
    $num = htmlspecialchars($_POST['phone1']);
    $lang = htmlspecialchars($_POST['language']);
    $contact = business::contact_us($num, $lang);
    if ($contact) {
      header("Location: " . $_SERVER['PHP_SELF'] . "?c1");
      exit();
    } else {
      echo '<div class="alert alert-danger" role="alert">Something went wrong! please try again</div>';
    }
  } else {
    header("location:/404error");
  } 
    $error = "Required fields missing.";
    echo $error;
  
}

?>


<section class="seller">
  <div class="container">
    <?php if (isset($_GET['s1'])) {
      echo '<div class="alert alert-success" id="submit_success" role="alert">Your Business deal is submitted! It will be listed after verification.</div>';
    }
    if (isset($_GET['c1'])) {
      echo '<div class="alert alert-success" id="contact_success" role="alert">Soon our team will contact you for guiding to sell your business.</div>';
    }

    ?>

    <div class="row">
      <!-- Left Column: Text Section -->
      <div class="col-lg-6 col-md-12">
        <h1 class="py-2 sell-heading">Sell with the <span class="highlight-text">#1</span> Team & Platform <span class="highlight-text">Globally</span></h1>
        <p class="text-center sell-text">Reach 15x more buyers on the most active marketplace</p>
        <h5 class="text-start py-2">Schedule a Live call from our team to guide you in selling your business.</h5>
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#callme">Call me</button>
      </div>

      <!-- Right Column: Image Section -->
      <div class="col-lg-6 col-md-12 text-center">
        <img class="img-fluid" src="./src/assets/seller.jpg" alt="business selling" loading="lazy">
      </div>
    </div>

    <!-- Steps Section -->
    <h3>Steps for Selling Your Business on <span class="highlight-text">Bizhub</span></h3>
    <div class="row">
      <div class="col-lg-4 col-md-12 text-center">
        <img src="./src/assets/seller4.jpeg" alt="step to sell" class="img-fluid" loading="lazy">
      </div>
      <div class="col-lg-8 col-md-12">
        <hr>
        <div class="step">
          <h5><span class="badge text-bg-success">Step 1</span></h5>
          <h5>Prepare Your Listing</h5>
          <p>Collect comprehensive details about your business, including financials, growth metrics, and unique selling points, to effectively showcase it to potential buyers on Bizhub.</p>
        </div>
        <div class="step">
          <h5><span class="badge text-bg-success">Step 2</span></h5>
          <h5>Create Your Listing</h5>
          <p>Utilize Bizhub's platform to craft a listing that highlights your business's strengths and appeals to a global audience of over 600,000 entrepreneurs, investors, and buyers.</p>
        </div>
        <div class="step">
          <h5><span class="badge text-bg-success">Step 3</span></h5>
          <h5>Interact with Interested Buyers</h5>
          <p>Respond to inquiries securely and efficiently through Bizhub's platform, guided by our Advisor Team.</p>
        </div>
        <div class="step">
          <h5><span class="badge text-bg-success">Step 4</h5>
          <h5>Secure Transaction Process</h5>
          <p>Leverage Bizhub's escrow service for a smooth and secure asset transfer, ensuring a successful business exit.</p>
        </div>
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#BusinessDetails">Sell now</button>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="BusinessDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Business Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="businessDetailsForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
          <!-- Business Name -->
          <div class="mb-3">
            <label for="businessName" class="form-label">Business Name</label>
            <input type="text" class="form-control" name="name" id="businessName" placeholder="Enter business name" required>
          </div>

          <!-- Business Type -->
          <div class="mb-3">
            <label for="businessType" class="form-label">Business Type</label>
            <select class="form-select" id="businessType" name="type" required>
              <option selected disabled value="">Select business type</option>
              <option value="Retail">Retail</option>
              <option value="E-commerce">E-commerce</option>
              <option value="Service">Service</option>
              <option value="Manufacturing">Manufacturing</option>
              <option value="Other1">Other</option>
            </select>
          </div>

          <!-- Business Industry -->
          <div class="mb-3">
            <label for="businessIndustry" class="form-label">Business Industry</label>
            <select class="form-select" name="industry" id="businessIndustry" required>
              <option selected disabled value="">Select industry</option>
              <option value="shopify">Shopify</option>
              <option value="adsence">Adsence</option>
              <option value="affilate">Affilate</option>
              <option value="Real Estate">Real Estate</option>
              <option value="manufacture">Manufacture</option>
              <option value="franchies">franchies</option>
              <option value="crypto">crypto</option>
              <option value="youtube channels">youtube channels</option>
              <option value="clothing">clothing</option>
              <option value="other2">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="floatingTextarea2">Description</label>
            <textarea class="form-control" name="description" placeholder="About Your Business" id="about business" style="height: 100px"></textarea>
          </div>

          <!-- Net Profit -->
          <div class="mb-3">
            <label for="netProfit" class="form-label">Net Profit</label>
            <input type="number" class="form-control" name="profit" id="netProfit" placeholder="Enter net profit" required>
          </div>

          <!-- Business Age -->
          <div class="mb-3">
            <label for="businessAge" class="form-label">Business Age (in years)</label>
            <input type="number" class="form-control" name="age" id="businessAge" placeholder="Enter business age" required>
          </div>

          <!-- Deal Price -->
          <div class="mb-3">
            <label for="dealPrice" class="form-label">Deal Price</label>
            <input type="number" class="form-control" id="dealPrice" name="price" placeholder="Enter deal price" required>
          </div>

          <!-- Business Location -->
          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter business location" required>
          </div>
          <!-- file upload -->
          <div class="mb-3">
            <label for="formFile" class="form-label">picture of your business</label>
            <input class="form-control" type="file" id="businessfile" name="file" accept="image/*" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="businessDetailsForm" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="callme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customer Support</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="supportForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <!-- Mobile Number -->
          <div class="mb-3">
            <label for="mobileNumber" class="form-label">Mobile Number</label>
            <input type="tel" class="form-control" name="phone1" id="mobileNumber" placeholder="Enter your mobile number" required>
          </div>

          <!-- Preferred Language -->
          <div class="mb-3">
            <label for="preferredLanguage" class="form-label">Preferred Language</label>
            <select class="form-select" name="language" id="preferredLanguage" required>
              <option selected disabled value="">Select your preferred language</option>
              <option value="English">English</option>
              <option value="Hindi">Hindi</option>
              <option value="kannada">kannada</option>
              <option value="Tamil">Tamil</option>
              <option value="malayalam">Malayalam</option>
              <option value="telegu">Telugu</option>
              <option value="others">others</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="supportForm" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<script>
  setTimeout(function() {
    $('#submit_success').hide();
    $('#contact_success').hide();

  }, 5000);
</script>