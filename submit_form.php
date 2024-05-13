<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validate and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : '';
    $message = htmlspecialchars($_POST['message']);

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo "Please fill out all required fields.";
        exit();
    }

    // Connect to SQLite database (adjust path if necessary)
    $db = new SQLite3('contact_info.db');

    // Prepare SQL statement to insert data
    $stmt = $db->prepare('INSERT INTO contacts (name, phone, email, message) VALUES (:name, :phone, :email, :message)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect to a thank you page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error submitting data.";
    }

    // Close database connection
    $db->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: contact_form.html");
    exit();
}
?>

