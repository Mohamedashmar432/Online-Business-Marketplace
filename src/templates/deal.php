<?php 
if(isset($_GET['id'])){
    $id =$_GET['id'];
   $deal_ = business::getOneBusiness($id);
   $deal = $deal_[0];
}
?>

<section class="deal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-7 col-sm-12 ">
                <h3 class="text-start my-3"><?php  echo $deal['business_name']; ?></h3>
                <div id="sitepic" class="carousel slide my-2 p-2">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="./src/assets/business/<?php echo $deal['business_file']; ?>" class="d-block w-100" alt="...">
                        </div>
                        <!-- <div class="carousel-item">
                            <img src="./src/assets/adsence.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="./src/assets/broker1.jpg" class="d-block w-100" alt="...">
                        </div> -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#sitepic" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#sitepic" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card py-2">
                    <div class="card-body py-2">
                        <h5 class="price-line" style=" display: flex;justify-content: space-between;font-weight: 300;">
                            <span class="price-label" style="font-weight: 400;">Starting price:</span>
                            <span class="price-amount" style="font-weight: 700;color:green">₹ <?php echo $deal['deal_price']; ?></span>
                        </h5>
                        <hr>
                        <span class="badge bg-success my-2"><?php echo $deal['deal_price']; ?></span>
                        <h6 style="display:flex;justify-content:space-between;font-weight:400;">
                            <span style="font-weight: 400;">Last date for bidding:</span>
                            <span style="font-weight: 700;"> 12/09/2024</span>
                        </h6>
                        <button type="button" class="btn btn-outline-primary">Place a Bid</button>
                        <hr>
                        <div class="card rounded">
                            <h4 class="card-title p-2">About seller</h4>
                            <div class="card-body">
                                <div class="d-flex">
                                    <img class="img-fluid rounded-circle" src="./src/assets/clothing.png" alt="seller profile" loading="lazy">
                                    <h5 class="mx-3"><?php echo $deal['business_author']; ?></h5><i class="bi bi-patch-check-fill text-primary"></i>
                                </div>
                                <span style="font-size: medium;"><i class="bi bi-geo-alt-fill my-2" style="margin-left:50px;"> India</i></span>
                                <hr>
                                <h4>Bizhub Verified</h4>
                                <div class="py-2 mx-3">
                                    <h6><i class="bi bi-patch-check-fill text-primary"> Email Verified</i></h6>
                                    <h6><i class="bi bi-patch-check-fill text-primary"> Phone Verified</i></h6>
                                    <h6><i class="bi bi-patch-check-fill text-primary"> Address Verified</i></h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2r my-2">
                            <a type="button" href="#" class="btn btn-outline-primary">Contact seller</a>
                            <a type="button" href="#" class="btn btn-primary my-2">Buy now</a>
                            <a type="button" href="#" class="btn btn-outline-primary">share it</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card my-2">
                <div class="card-body">
                    <h5 class="card-title p-2">About business</h5>
                    <hr>
                    <p class="mx-2"><?php echo $deal['description']; ?></p>
                    <h5 class="card-title p-2">Financial Statistics</h5>
                    <hr>
                    <div class="row mx-2">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <h6>Type</h6>
                            <p><?php echo $deal['business_type']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <h6>Industry</h6>
                            <p><?php echo $deal['business_industry']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <h6>Net profit</h6>
                            <p>₹ <?php echo $deal['net_profit']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <h6>Business Age</h6>
                            <p><?php echo $deal['business_age']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>