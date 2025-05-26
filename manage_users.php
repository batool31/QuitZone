<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "quitzone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, username, email, role FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="grad.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fa;
            padding: 40px;
        }

        .admin-container {
            max-width: 950px;
            margin: auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
        }

        table th {
            background-color: #d46b60;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .logout-link {
            float: right;
            margin-top: -35px;
            background: #2e293a;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
        }

        .logout-link:hover {
            background: #222;
        }

        .delete-btn {
            background-color: #2e293a;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #222;
        }

        .no-users {
            text-align: center;
            color: #888;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <a href="logout.php" class="logout-link">Logout</a>
        <h2>Manage Users 👥</h2>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="success-message">✅ تم حذف المستخدم بنجاح.</div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <?php if ($user['role'] !== 'admin'): ?>
                                <form method="POST" action="delete_user.php" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            <?php else: ?>
                                <span style="color: gray;">Admin</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="no-users">لا يوجد مستخدمون حاليًا.</div>
        <?php endif; ?>
    </div>
</body>
</html>
