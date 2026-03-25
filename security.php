<?php
include 'db.php';

if (isset($_POST['block_visitor'])) {
    $name = $_POST['full_name'];
    $contact = $_POST['contact_number'];
    $reason = $_POST['reason'];
    $conn->query("INSERT INTO blocklist (full_name, contact_number, reason) VALUES ('$name', '$contact', '$reason')");
}

if (isset($_GET['unblock_id'])) {
    $id = $_GET['unblock_id'];
    $conn->query("DELETE FROM blocklist WHERE id = $id");
    header("Location: security.php");
}

$blocked_list = $conn->query("SELECT * FROM blocklist ORDER BY blocked_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Security - Amen's VMS</title>
</head>
<body class="bg-gray-50 font-['Poppins']">
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-red-600">Security Blocklist</h1>
        
        <div class="bg-white p-6 rounded-xl shadow-md mb-10">
            <h2 class="text-lg font-semibold mb-4">Block a Person</h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="full_name" placeholder="Full Name" class="border p-2 rounded" required>
                <input type="text" name="contact_number" placeholder="Contact/Phone" class="border p-2 rounded" required>
                <input type="text" name="reason" placeholder="Reason (e.g., Unruly behavior)" class="border p-2 rounded" required>
                <button type="submit" name="block_visitor" class="bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">Block Access</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4">Name</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Reason</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($b = $blocked_list->fetch_assoc()): ?>
                    <tr class="border-b">
                        <td class="p-4 font-bold"><?= $b['full_name'] ?></td>
                        <td class="p-4"><?= $b['contact_number'] ?></td>
                        <td class="p-4 text-sm text-gray-600"><?= $b['reason'] ?></td>
                        <td class="p-4">
                            <a href="security.php?unblock_id=<?= $b['id'] ?>" class="text-blue-600 hover:underline">Unblock</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>