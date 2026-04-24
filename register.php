<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<body>
    <form action="" method="post">
        <label for="imie">imie<input type="text" name="imie" id="imie"></label>
        <label for="email">Email<input type="email" name="email" id="email"></label>
        <label for="pswd">Haslo<input type="password" name="pswd" id="pswd"></label>
        <label for="phone">Numer Telefonu<input type="tel" name="phone" id="phone"></label>
        <button type="submit">Zarejestruj</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["imie"])&&!empty($_POST["email"])&&!empty($_POST["pswd"]) && !empty($_POST["phone"])) {
            $conn = mysqli_connect("localhost", "root", "y", "kresowaJeden");
            $name = mysqli_real_escape_string($conn, $_POST["imie"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, password_hash($_POST["pswd"], PASSWORD_DEFAULT));
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
            $sql = "SELECT email FROM klienci WHERE email = '$email'";
            $validate = mysqli_query($conn, $sql);
            if ($validate && mysqli_num_rows($validate) > 0) {
                echo "<p>Istnieje już użytkownik o tym loginie!</p>";
            } else {
                $newUser = "INSERT INTO klienci VALUES(null, '$name', '$password','$email', '$phone')";
                $addUser = mysqli_query($conn, $newUser);
                echo "<p>Zostałeś zarejestrowany! Kliknij <a href='login.php'>tutaj</a>, aby się zalogować.";
            }
        } else {
            echo "<p>Musisz wpisać swoje dane!.</p>";
        }
    }
    ?>
</body>
</html>