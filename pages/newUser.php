
<?php
require_once('./connection/connectionString.php');

if (isset($_POST['submit'])) {
  $username = strip_tags($_POST["username"]);
  $email = strip_tags($_POST["email"]);
  $role = 'participant';
  $password = strip_tags($_POST["password"]);
  $passwordCheck = strip_tags($_POST['passwordCheck']);
  if ($password != $passwordCheck){
    echo "<script>alert('Passwords do not match');</script>";
  } else{
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
}

?>

<main>
    <form class="form" method="post">
        <div class="title">Welcome</div>
        <div class="subtitle">Create New Account</div>
        <div class="input-container ic1">
            <input id="username" name="username" class="input" type="username" placeholder=" " required/>
            <div class="cut"></div>
            <label for="username" class="placeholder">Username</label>
        </div>
        <div class="input-container ic2">
            <input id="email" name="email" class="input" type="email" placeholder=" " required/>
            <div class="cut"></div>
            <label for="email" class="placeholder">Email</label>
        </div>
        <div class="input-container ic2">
            <input id="password" name="password" class="input" type="password" placeholder=" " required/>
            <div class="cut"></div>
            <label for="password" class="placeholder">Password</label>
        </div>
        <div class="input-container ic2">
            <input id="passwordCheck" name="passwordCheck" class="input" type="password" placeholder=" " required/>
            <div class="cut"></div>
            <label for="passwordCheck" class="placeholder">Confirm Password</label>
        </div>
        <button type="submit" name="submit" class="submit">submit</button>
    </form>
</main>