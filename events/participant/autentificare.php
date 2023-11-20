<?php
session_start();
// informatii conectare.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'eventify3';
// Încercați să vă conectați folosind informațiile de mai sus.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER,
    $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
// Dacă există o eroare la conexiune, opriți scriptul și afișați eroarea.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Acum verificăm dacă datele din formularul de autentificare au fost trimise, isset () va verifica dacă datele există.
if ( !isset($_POST['email'], $_POST['password']) ) {
// Nu s-au putut obține datele care ar fi trebuit trimise.
    exit('Completati username si password !');
}
// Pregătiți SQL-ul nostru, pregătirea instrucțiunii SQL va împiedica injecția SQL.
if ($stmt = $con->prepare('SELECT ID, nume, parola FROM participant WHERE 
email = ?')) {
// Parametrii de legare (s = șir, i = int, b = blob etc.), în cazul nostru numele de utilizator este un șir, //așa că vom folosi „s”
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
// Stocați rezultatul astfel încât să putem verifica dacă contul există în baza de date.
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nume, $password);
        $stmt->fetch();
// Contul există, acum verificăm parola.
// Notă: nu uitați să utilizați password_hash în fișierul de înregistrare pentru a stoca parolele hash.
        if (password_verify($_POST['password'], $password)) {
// Verification success! User has loggedin!
// Creați sesiuni, astfel încât să știm că utilizatorul este conectat, acestea acționează practic ca cookie-//uri, dar rețin datele de pe server.
            session_regenerate_id();
            $_SESSION['loggedinParticipant'] = TRUE;
            $_SESSION['numeParticipant'] = $nume;
            $_SESSION['idParticipant'] = $id;
            header('Location: /proiect/events/');
        } else {
// password incorrect
            echo 'Incorrect email sau password!';
        }
    } else {
// username incorect
        echo 'Incorrect email sau password!';
    }
    $stmt->close();
}
?>
