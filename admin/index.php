<?php
include("./partials/conectare.php");
include("./partials/auth_check.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pagina proiect parolata</title>
</head>
<body class="loggedin">
<?php include './partials/navbar.php';?>
<div class="container mt-4">
    <p>Welcome back, <?=$_SESSION['nameOrganizator']?>!</p>
    <h2>Your Events</h2>
    <a class="btn btn-info" href="/proiect/admin/create"><i class="fas fa-calendar"></i> Create a new event</a>
    <?php
    if ($result = $mysqli->query("SELECT * FROM eveniment WHERE IDOrganizator =" . $_SESSION['idOrganizator'] . " ORDER BY ID")) {
        if ($result->num_rows > 0) {
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>ID</th><th>Title</th><th>Description</th><th>Start Date</th><th>End Date</th><th>Agenda</th><th>Location</th><th></th><th></th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_object()) {
                echo "<tr id=" . $row->ID . ">";
                echo "<td>" . $row->ID . "</td>";
                echo "<td>" . $row->titlu . "</td>";
                echo "<td>" . $row->descriere . "</td>";
                echo "<td>" . $row->data_inceput . "</td>";
                echo "<td>" . $row->data_sfarsit . "</td>";
                echo "<td>" . $row->agenda . "</td>";
                echo "<td>" . $row->locatie . "</td>";
                echo "<td><a class='btn btn-primary' href='/proiect/admin/edit?id=" . $row->ID . "'>Edit</a></td>";
                echo "<td><button class='btn btn-danger remove' id='delete-btn'>Delete</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>No records found in the table!</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $mysqli->error . "</div>";
    }
    $mysqli->close();
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(".remove").click(function(){
            var id = $(this).parents("tr").attr("id");

            if(confirm('Sigur doresti stergerea acestui eveniment?'))
            {
                window.location.href = "/proiect/admin/delete?id=" + id;
            }
        });
    </script>

</div>
</body>
</html>

