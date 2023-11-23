<?php include '../partials/auth_check.php';
include '../partials/conectare.php';
 include '../partials/navbar.php';?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Contract</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div class="container mt-5">
<h1>Inregistrarile din tabela contracte</h1>
<p><b>Toate inregistrarile din contracte</b</p>
<?php



    $query = "
    SELECT contract.*, colaborator.nume AS NumeColaborator, eveniment.titlu AS TitluEveniment
    FROM contract
    INNER JOIN colaborator ON contract.IDColaborator= colaborator.id 
    INNER JOIN eveniment ON contract.IDEveniment = eveniment.id 
    WHERE eveniment.IDOrganizator = ?
    ORDER BY contract.ID
";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("i", $_SESSION['idOrganizator']);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Numar</th><th>Data Semnarii</th><th>Tip</th><th>Colaborator</th><th>Eveniment</th><th>Acțiuni</th></tr>";
        while ($row = $result->fetch_object()) {
            echo "<tr id=' " . $row->ID . "'>";
            echo "<td>" . htmlspecialchars($row->ID) . "</td>";
            echo "<td>" . htmlspecialchars($row->NUMAR) . "</td>";
            echo "<td>" . htmlspecialchars($row->data_semnarii) . "</td>";
            echo "<td>" . htmlspecialchars($row->tip) . "</td>";
            echo "<td>" . htmlspecialchars($row->NumeColaborator) . "</td>";
            echo "<td>" . htmlspecialchars($row->TitluEveniment) . "</td>";
            echo "<td><a class='btn btn-primary' href='/proiect/admin/contract/modificare.php?id=" . htmlspecialchars($row->ID) . "'>Modificare</a> ";
            echo "<a class='btn btn-primary' href='stergere.php?id=" . htmlspecialchars($row->ID) . "'>Stergere</a> </td>";
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
<a href="/proiect/admin/contract/inserare.php">Adauga o noua inregistrarare</a>
</div>
</body>
</html>


