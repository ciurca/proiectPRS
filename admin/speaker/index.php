<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
$IDOrganizator = $_SESSION['id'];
include('../partials/navbar.php');
?>
<html>
<head>
    <title>Speakers </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div class="container mt-5">
<h1>Speakerii evenimentelor tale</h1>
<?php

$query = "
    SELECT speaker.*, eveniment.titlu AS TitluEveniment 
    FROM speaker 
    INNER JOIN eveniment ON speaker.IDEveniment = eveniment.id 
    WHERE eveniment.IDOrganizator = ? 
    ORDER BY speaker.ID
";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("i", $IDOrganizator);
    $stmt->execute();

    // Get the result set from the prepared statement
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Nume</th><th>Prenume</th><th>Email</th><th>Telefon</th><th>Eveniment</th><th>Acțiuni</th></tr>";
        while ($row = $result->fetch_object()) {
            echo "<tr id=' ". $row->ID ."'>";
            echo "<td>" . htmlspecialchars($row->ID) . "</td>";
            echo "<td>" . htmlspecialchars($row->nume) . "</td>";
            echo "<td>" . htmlspecialchars($row->prenume) . "</td>";
            echo "<td>" . htmlspecialchars($row->email) . "</td>";
            echo "<td>" . htmlspecialchars($row->telefon) . "</td>";
            echo "<td>" . htmlspecialchars($row->TitluEveniment) . "</td>";
            echo "<td><a class='btn btn-primary' href='modificare.php?id=" . htmlspecialchars($row->ID) . "'>Modificare</a> ";
            echo "<a class='btn btn-danger remove' id='delete-btn' >Stergere</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nu exista inregistrari in tabela!";
    }

    // Close the statement
    $stmt->close();
}
else
{ echo "Error: " . $mysqli->error(); }
$mysqli->close();
?>
    <br>
<a href="inserare.php" class="btn btn-primary"><i class="fas fa-plus"></i> Adauga un nou speaker</a>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");

        if(confirm('Sigur doresti stergerea acestui speaker?'))
        {
            window.location.href = "/proiect/admin/speaker/delete.php?id=" + id;
        }
    });
</script>
</body>
</html>

