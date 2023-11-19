<?php
include '../partials/auth_check.php';
include '../partials/conectare.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Colaboratori</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>Inregistrarile din tabela colaboratori</h1>
<p><b>Toate inregistrarile din colaboratori</b</p>
<?php
if ($result = $mysqli->query("SELECT * FROM colaborator ORDER BY ID "))
{
    if ($result->num_rows > 0)
    {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Nume</th><th>Telefon</th><th>Email</th><th>Tip</th><th>Suma</th><th>Premii</th><th>Tip Parteneriat</th><th>Operatii</th></tr>";
        while ($row = $result->fetch_object())
        {
            echo "<tr>";
            echo "<td>" . $row->ID . "</td>";
            echo "<td>" . $row->nume . "</td>";
            echo "<td>" . $row->telefon . "</td>";
            echo "<td>" . $row->email . "</td>";
            echo "<td>" . $row->tip . "</td>";
            echo "<td>" . $row->suma . "</td>";
            echo "<td>" . $row->premii. "</td>";
            echo "<td>" . $row->tip_parteneriat. "</td>";
            echo "<td><a href='modificare.php?id=" . $row->ID . "'>Modificare colaborator</a>  ";
            echo "<a href='stergere.php?id=" .$row->ID . "'>Stergere colaborator</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "Nu exista inregistrari in tabela!";
    }
}
else
{ echo "Error: " . $mysqli->error(); }
$mysqli->close();
?>
<a href="inserare.php">Adauga o noua inregistrarare</a>
</body>
</html>


