<?php
require_once('./connection/connectionString.php');

if (isset($_POST['submit'])) {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $role = $_POST["role"];
  $password = $_POST["password"];

  // hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);


  // insert user details into user table
  $stmt = $conn->prepare("INSERT INTO user (userName, email, role) VALUES (:username, :email, :role)");
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':role', $role);
  $stmt->execute();

  // get the ID of the new user
  $userID = $conn->lastInsertId();

  // insert hashed password value into password table
  $stmt = $conn->prepare("INSERT INTO password (userID, password_hash) VALUES (:userID, :password_hash)");
  $stmt->bindParam(':userID', $userID);
  $stmt->bindParam(':password_hash', $hashed_password);
  $stmt->execute();

  // redirect the user to the login page
  header('Location: index.php?page=login');
  exit();
}

?>

<form method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username" required>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>
  <label for="role">Role:</label>
  <select id="role" name="role" required>
    <option value="organiser">Organiser</option>
    <option value="participant">Participant</option>
  </select>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>
  <input type="submit" name="submit" value="Submit">
</form>
