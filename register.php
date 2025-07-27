/**
 * User Registration Script
 *
 * This script handles user registration for the authentication system.
 * 
 * Features:
 * - Validates user input for email, username, and password.
 * - Username must be 3-20 characters, containing only letters, numbers, and underscores.
 * - Email must be in a valid format.
 * - Password must be at least 8 characters, with at least one uppercase letter and one number.
 * - Checks for duplicate email or username in the database.
 * - Hashes the password before storing it.
 * - Displays success or error messages based on registration outcome.
 *
 * Dependencies:
 * - Requires "config.php" for database connection ($conn).
 * - Requires "includes/header.php" and "includes/footer.php" for layout.
 *
 * Usage:
 * - Presents a registration form to the user.
 * - On form submission, processes and validates input, then attempts to register the user.
 *
 * Security:
 * - Uses prepared statements to prevent SQL injection.
 * - Hashes passwords using PHP's password_hash() function.
 */
<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Allow only alphanumeric usernames (adjust regex as needed)

    if (empty($email) || empty($username) || empty($password)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        echo "<div class='alert alert-danger'>Username must be 3-20 characters and contain only letters, numbers, and underscores.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Please enter a valid email address.</div>";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        echo "<div class='alert alert-danger'>Password must be at least 8 characters long and contain at least one uppercase letter and one number.</div>";
    } else {
    
      // Check for duplicate email or username
        $check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
        $check->execute([
            ':email' => $email,
            ':username' => $username
        ]);
        $count = $check->fetchColumn();

        if ($count > 0) {
            echo "<div class='alert alert-danger'>Email or username already exists.</div>";
        } else {
            try {
                $insert = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
                $insert->execute([
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                ]);

                if ($insert->rowCount() > 0) {
                    echo "<div class='alert alert-success'>Registration successful!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Registration failed. Please try again.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }
}
?>

<main class="form-signin w-50 m-auto">
  <form method="POST" action="register.php">
   
    <h1 class="h3 mt-5 fw-normal text-center">Please Register</h1>

    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInput" placeholder="username">
      <label for="floatingInput">Username</label>
    </div>

    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">register</button>
    <h6 class="mt-3">Aleardy have an account?  <a href="login.php">Login</a></h6>

  </form>
</main>
<?php require "includes/footer.php"; ?>
