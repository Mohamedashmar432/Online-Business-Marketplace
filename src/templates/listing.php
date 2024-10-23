<section class="buyer-section">
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <input type="text" class="form-control search-input" placeholder="Search Business">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <select class="form-control search-select" id="locationSelect" placeholder="Select Location">
                                <option>Tamil Nadu</option>
                                <option>Karnataka</option>
                                <option>Kerala</option>
                                <option>Andhra Pradesh</option>
                                <option>Telangana</option>
                                <option>Delhi</option>
                                <option>Maharashtra</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                            <button type="button" class="btn btn-primary search-btn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <h3 class="explore-heading text-start py-4">Explore our Top <span class="highlight-text">Business</span> listed below: </h3>
        <?php
        $list =  business::getAllBusiness();

        foreach ($list as $deal) { ?>
        <div class="container">
            <div class="row justify-content-center">
                <a href="/deal.php?id=<?php echo $deal['id']; ?>" class="business-card-link col-lg-12 col-md-10 col-sm-12 mb-3">
                    <div class="card business-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <img class="business-image img-thumbnail" src="./src/assets/business/<?echo $deal['business_file']; ?>" alt="buyer" loading="lazy">
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="card-title text-start business-title">
                                        <h4><? echo $deal['business_name']; ?></h4>
                                    </div>
                                    <span class="badge rounded-pill text-bg-success">Verified Listing</span>
                                    <p class="text-start business-description"><? echo $deal['description']; ?></p>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            <h6>Type</h6>
                                            <p><?echo $deal['business_type']; ?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            <h6>Industry</h6>
                                            <p><? echo $deal['business_industry']; ?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            <h6>Net profit</h6>
                                            <p><? echo $deal['net_profit']; ?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            <h6>Business Age</h6>
                                            <p><? echo $deal['business_age']; ?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6 deal-price">
                                            <h6>Deal price</h6>
                                            <p><? echo $deal['deal_price']; ?></p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-6">
                                            <span class="badge rounded-pill text-bg-info"><?  echo $deal['bid'];?> bid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
</section>
