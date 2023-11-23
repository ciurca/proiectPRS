<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/proiect/admin/">Eventify Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        if (isset($_SESSION['idOrganizator'])) { ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/profile?id=<?=$_SESSION['idOrganizator']?>"><i class="fas fa-user-circle"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/speaker"><i class="fas fa-comment"></i> Speakers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/contract"><i class="fas fa-file"></i> Contracte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/colaborator"><i class="fas fa-dollar-sign"></i> Colaboratori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/bilete"><i class="fas fa-ticket-alt"></i> Bilete</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
        <?php } else { ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/proiect/admin/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
            </ul>
        </div>
        <?php
        }
        ?>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>