
<?php
require_once('./connection/connectionString.php');

if (isset($_POST['submit'])) {
  $username = strip_tags($_POST["username"]);
  $email = strip_tags($_POST["email"]);
  $role = 'participant';
  $password = strip_tags($_POST["password"]);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare('SELECT email FROM user WHERE email = :email');
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $usedEmail = $stmt->fetch();
  if ($usedEmail){
    echo "<script>alert('Email already exists');</script>";
  } else{
    $stmt = $conn->prepare("CALL newUserCreate(:username, :email, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    $stmt = $conn->prepare("CALL newUserGetID(:email)");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $ID = $stmt->fetch();
    $userID = $ID['userID'];
    
    $stmt = $conn->prepare("CALL newUserPass(:userID, :password_hash)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':password_hash', $hashed_password);
    $stmt->execute();

  if(isset($_GET['id'])){

    header('Location: ./index.php?page=login&id=' . $_GET['id']);
  } else
  header('Location: ./index.php?page=login');
  exit();
  }
}

?>
<main>
  <form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <input type="submit" name="submit" value="Submit">
  </form>
</main>