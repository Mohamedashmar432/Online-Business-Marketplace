<?php 
$brokers_file = file_get_contents('./tools/broker.json');
$brokers = json_decode($brokers_file, true);
?>
<section class="broker-section">
    <div class="container my-5 ">
        <div class="row justify-content-center">
            <h2 class="text-center">Meet Our Expert <span style="color:dodgerblue;">Brokers</h2>
            <p class="text-center lead">Our experienced brokers are here to help you buy or sell your business globally.</p>
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Search brokers by region, experience, or specialty">
                </div>
            </div>
            <?php foreach($brokers as $broker){ ?>
            <div class=" col-md-4 col-sm-12 mb-4">
                <div class="card broker-card shadow-sm">
                    <img src="./src/assets/<?php echo $broker['photo']; ?>" class="card-img-top" alt="Amber Burke" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title">
                            <img src="./src/assets/linkedin_icon.svg" alt="LinkedIn Logo" class="me-2">
                            <a href="#" class="broker-name"><?php echo $broker['name']; ?></a>
                        </h5>
                        <p class="broker-title">Business Broker</p>
                        <p class="broker-location">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <?php echo $broker['location']; ?>
                        </p>
                        <p class="broker-description">
                        <?php echo $broker['description']; ?>
                        </p>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>