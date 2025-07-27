# User Registration Script (vanilla PHP)

This script handles user registration for the authentication system. -->
 Features:
 - Validates user input for email, username, and password.
 - Username must be 3-20 characters, containing only letters, numbers, and underscores.
 - Email must be in a valid format.
 - Password must be at least 8 characters, with at least one uppercase letter and one number.
 - Checks for duplicate email or username in the database.
 - Hashes the password before storing it.
 - Displays success or error messages based on registration outcome.

 Dependencies:
 - Requires "config.php" for database connection ($conn).
 - Requires "includes/header.php" and "includes/footer.php" for layout.

 Usage:
 - Presents a registration form to the user.
 - On form submission, processes and validates input, then attempts to register the user.

 Security:
 - Uses prepared statements to prevent SQL injection.
 - Hashes passwords using PHP's password_hash() function.
