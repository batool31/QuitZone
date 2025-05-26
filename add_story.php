<?php
include 'data.Base.php'; // ملف الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $smoker_years = intval($_POST['smoker_years']);
    $smoke_free_duration = mysqli_real_escape_string($conn, $_POST['smoke_free_duration']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);
    $achievements = mysqli_real_escape_string($conn, $_POST['achievements']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = 'uploads/';
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO success_stories 
            (name, location, smoker_years, smoke_free_duration, story, achievements, image_url) 
            VALUES ('$name', '$location', $smoker_years, '$smoke_free_duration', '$story', '$achievements', '$target_file')";

            if (mysqli_query($conn, $sql)) {
                header('Location: admin_dashboard.php?msg=Story added successfully');
                exit();
            } else {
                echo "Database error: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image upload error.";
    }
}
?>
