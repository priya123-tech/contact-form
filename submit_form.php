submit_form.php
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Connect to SQLite database
    $db = new SQLite3('contact_info.db');

    // Prepare SQL statement to insert data
    $stmt = $db->prepare('INSERT INTO contacts (name, phone, email, message) VALUES (:name, :phone, :email, :message)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "Data submitted successfully!";
    } else {
        echo "Error submitting data.";
    }

    // Close database connection
    $db->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: ./contact_form.html");
    exit();
}
?>
