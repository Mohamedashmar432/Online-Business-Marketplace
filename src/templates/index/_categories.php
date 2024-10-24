<?php
$business = ["shopify", "adsence", "affilate", "e-commerce", "restaurent", "manufacture", "franchies", "crypto", "hotels", "youtube_channels", "clothing", "real_estate"];
?>
<section class="categories pt-5" id="categories">
    <div class="container" data-aos="fade-up">
        <h4 class="text-center py-4">
            <span class="badge text-bg-primary rounded-pill animate__animated animate__slideInUp">Top Business Categories</span>
        </h4>
        <h3 class="text-center py-2">What started as a passionate side hustle is now a<span class="highlight-text"> $2M networth business</span></h3>

        <div class="row">
            <!-- Category Card 1 -->
            <?php foreach ($business as $busines) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 ">
                    <a href="#" class="card-link">
                        <div class="category-card">
                            <div class="category-content">
                                <span class="icon-box"><img src="./src/assets/<?php echo $busines; ?>.png" class="icon-img"></span>
                                <h5 class="category-title"><?php print(ucfirst(str_replace('_', ' ', $busines))); ?> </h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <!-- <div id="barchart_values" style="width: 900px; height:auto;"></div> -->
    </div>
</section>

<!-- <script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Business", "Demand", {
                role: "style"
            }],
            ["Shopify", 68.94, "green"],
            ["Adsence", 52.49, "blue"],
            ["Affilate", 30.30, "#800080"],
            ["E-commerce", 50.45, "color: orange"],
            ["Restaurants", 40.45, "color:dodgerblue"],
            ["Manufacture", 50.45, "color: #e5e4e2"],
            ["Franchise", 60.45, "color:#808080"],
            ["Crypto", 55.45, "color: gold"],
            ["Youtube channels", 67.45, "color: red"],
            ["Hotels", 32.45, "color:yellow"],
            ["Clothing", 70.45, "color: #008080"],
            ["Real State", 48.45, "color:#DCAE96"]
            

        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: " compare trending assets and categories.",
            width: 900,
            height: 800,
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
        chart.draw(view, options);
    }
</script> -->