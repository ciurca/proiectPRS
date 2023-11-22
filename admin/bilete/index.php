<?php
include("../partials/conectare.php");
include('../partials/auth_check.php');
$IDOrganizator = $_SESSION['idOrganizator'];
include('../partials/navbar.php');
?>
<html>
<head>
    <title>Bilete </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div class="container mt-5">
<h1>Biletele evenimentelor tale</h1>
<?php

$query = "
    SELECT bilet.*, eveniment.titlu AS TitluEveniment 
    FROM bilet 
    INNER JOIN eveniment ON bilet.IDEveniment = eveniment.id 
    WHERE eveniment.IDOrganizator = ? 
    ORDER BY bilet.ID
";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("i", $IDOrganizator);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Eveniment</th><th>Tip</th><th>Pret</th><th>Acțiuni</th></tr>";
        while ($row = $result->fetch_object()) {
            echo "<tr id='". $row->ID ."'>";
            echo "<td>" . htmlspecialchars($row->TitluEveniment) . "</td>";
            echo "<td>" . htmlspecialchars($row->tip) . "</td>";
            echo "<td>" . htmlspecialchars($row->pret) . "</td>";
            echo "<td><a class='btn btn-primary' href='modificare.php?id=" . htmlspecialchars($row->ID) . "'>Modificare</a> ";
            echo "<td><a class='btn btn-danger' href='delete.php?id=" . htmlspecialchars($row->ID) . "'>Stergere</a> ";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nu exista inregistrari in tabela!";
    }

    $stmt->close();
}
else
{ echo "Error: " . $mysqli->error(); }
$mysqli->close();
?>
    <br>
<a href="inserare.php" class="btn btn-primary"><i class="fas fa-plus"></i> Adauga un nou bilet</a>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");

        if(confirm('Sigur doresti stergerea acestui bilet?'))
        {
            window.location.href = "/proiect/admin/bilet/delete.php?id=" + id;
        }
    });
</script>
</body>
</html>

