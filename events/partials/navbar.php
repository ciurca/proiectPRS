<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/proiect/events/">Eventify Evenimente</a>
        <?php
        if (isset($_SESSION['numeParticipant'])) { ?>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/events/participant/bilete.php"><i class="fas fa-ticket-alt"></i> Biletele mele</a>
                </li>
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/events/shop/cos.php"><i class="fas fa-shopping-cart"></i> Cos</a>
                </li>
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/events/participant/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
        <?php } else { ?>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/events/participant/"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            </ul>
        </div>
        <?php
        }
        ?>
    </div>
</nav>