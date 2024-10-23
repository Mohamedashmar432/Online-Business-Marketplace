<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3" style="background-color: dodgerblue;">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Bizhub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-4"><a class="nav-link text-white" href="/">Home</a></li>
                <li class="nav-item mx-4"><a class="nav-link text-white" href="/#aboutus">About</a></li>
                <li class="nav-item mx-4"><a class="nav-link text-white" href="/#categories">Categories</a></li>
                <li class="nav-item dropdown mx-4">
                    <a class="nav-link  text-white" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/listing.php">Discover business</a></li>
                        <li><a class="dropdown-item" href="/seller.php">sell your business</a></li>
                        <li><a class="dropdown-item" href="/broker.php">Meet out Brokers</a></li>
                        <li><a class="dropdown-item" href="/buyer.php">Connect with Buyers</a></li>
                    </ul>
                </li>
                <li class="nav-item mx-4"><a class="text-white nav-link" href="/#cantactus">Contact</a></li>
                <?php if (Session::isAuthenticated() ) { ?>
                    <li class="nav-item mx-4">
                        <a class="text-white nav-link" href="/profile.php">Profile</a>
                    </li>
                    <li class="nav-item mx-4">
                        <button class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-chat-square-text-fill"></i></button>
                    </li>
                    <li class="nav-item mx-4">
                    <a class="text-black nav-link" href="/?logout">log out <?php session::logout(); ?></a>
                </li>
                    <?php } else { ?>
                    <li class="nav-item mx-4">
                        <a class="text-black nav-link" href="/signin.php">Signin</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="text-black nav-link" href="/signup.php">Signup</a>
                    </li><?php } ?>

            </ul>
        </div>
    </div>
</nav>
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Messages</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <hr>

    </div>
</div>