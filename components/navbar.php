
<!-- Navbar component - Inject (include "../components/navbar.php) navbar in other php files -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">Pet Social</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <!-- Show the user's name in navbar if logged in -->
    <?php
        if (isset($_SESSION['email'])) {
            echo $_SESSION['email'];
        }

    ?>
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/petSocialMedia/main/home.php">Home <span class="sr-only">(current)</span></a>
        </li>

            <!-- Show logout button if logged in -->
            <?php
            if (isset($_SESSION['email'])){ 
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/main/searchUsers.php">
                        Search Users
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/main/meetups.php">
                        Meetups
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/main/recipes.php">
                        Recipes
                    </a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/main/training.php">
                        Training
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/user/dashboard.php">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/petSocialMedia/login/logout.php">
                        Logout
                    </a>
                </li>
                <?php
            }
            // If not logged in, show login and register buttons
            else {
                ?>

                <li class="nav-item">
                <a class="nav-link" href="/petSocialMedia/login/login.php">
                    Login
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/petSocialMedia/login/register.php">
                    Register
                </a>
                </li>
                <?php
            }
            ?>
    </ul>
</div>
</nav>

