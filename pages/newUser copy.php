<?php
require_once('./connection/connectionString.php'); // include the connection string

// define variables and set to empty values
$username = $email = $role = $hashed_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // validate input data
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $role = test_input($_POST["role"]);
  $password = test_input($_POST["password"]);

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

  // redirect the user to the login page or a confirmation page
  // header('Location: index.php?page=login');
  var_dump($userID);
  var_dump($userName);
  var_dump($email);
  var_dump($role);
  // exit();
}

// helper function to validate input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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

  <input type="submit" value="Submit">
</form>
