<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand text-primary fw-bold" href="../discuss"><span class="text-danger fs-4">V</span>artaLaap <br>
            <span class="fs-6 mt-0 text-danger fw-normal fst-italic">to Solution</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/testProjects/discuss/') ? 'active' : '' ?>" href="../discuss">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['askquestion']) ? 'active' : '' ?>" href="?askquestion=true">Ask question</a>
                </li>
                <?php


                if (isset($_SESSION['user'])) {
                ?>


                    <li class="nav-item">
                        <a class="nav-link <?php echo isset($_GET['viewQuestions']) ? 'active' : '' ?>" href="?viewQuestions=true">View Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold" href="../discuss/server/requests.php?logout=true">Logout</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-bold text-primary dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome
                            <?php
                            if (isset($_SESSION['user']['username'])) {
                                echo htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                            }
                            ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="?profile=true">Profile</a></li>
                            <li><a class="dropdown-item" href="?changePassword=true">Change Password</a></li>

                        </ul>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isset($_GET['login']) ? 'active' : '' ?>" href="?login=true">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isset($_GET['signup']) ? 'active' : '' ?>" href="?signup=true">Sign up</a>
                    </li>
                <?php
                }
                ?>

            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" id="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button class="btn btn-outline-success" type="button" id="searchBtn" onclick="searchBtnFunction(event)" name="searchBtn">Search</button>
            </form>
        </div>
    </div>
</nav>