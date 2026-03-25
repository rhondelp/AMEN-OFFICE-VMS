<?php
include 'db.php';
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
    
    $check_block = $conn->query("SELECT * FROM blocklist WHERE full_name = '$name' OR contact_number = '$contact'");
    
    $check_inside = $conn->query("SELECT * FROM visitors WHERE (full_name = '$name' OR contact_number = '$contact') AND status = 'Inside'");

    if ($check_block && $check_block->num_rows > 0) {
        $block_data = $check_block->fetch_assoc();
        $error_message = "❌ ACCESS DENIED: This visitor is on the blocklist. Reason: " . $block_data['reason'];
    } 
    else if ($check_inside && $check_inside->num_rows > 0) {
        $error_message = "⚠️ DUPLICATE ENTRY: This visitor is already checked-in and currently inside the office.";
    } 
    else {
        $gender  = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
        $host    = mysqli_real_escape_string($conn, $_POST['person_to_visit']);

        $sql = "INSERT INTO visitors (full_name, contact_number, gender, address, purpose_of_visit, person_to_visit, status) 
                VALUES ('$name', '$contact', '$gender', '$address', '$purpose', '$host', 'Inside')";

        if ($conn->query($sql)) {
            $success_message = "✅ Visitor registered successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Visitor - Amen's VMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-orange-500 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full bg-white shadow-2xl rounded-3xl overflow-hidden flex flex-col md:flex-row" data-aos="zoom-in">
        <div class="md:w-1/3 bg-slate-900 p-8 text-white flex flex-col justify-center">
            <h2 class="text-2xl font-bold mb-2 text-orange-500">Amen's Office</h2>
            <p class="text-gray-400 text-sm">Please provide accurate details for security purposes.</p>
            <div class="mt-8">
                <a href="index.php" class="text-xs font-semibold bg-orange-600 hover:bg-orange-700 py-2.5 px-4 rounded-xl transition inline-block shadow-lg shadow-orange-900/20">← Home Page</a>
            </div>
        </div>

        <div class="md:w-2/3 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Visitor Registration</h2>

            <?php if($error_message): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl text-sm" data-aos="shake">
                    <p class="font-bold">Security Alert</p>
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <?php if($success_message): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-xl text-sm animate-bounce">
                    <?= $success_message ?>
                    <p class="text-xs mt-1 underline"><a href="dashboard.php">View in Dashboard</a></p>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Full Name</label>
                        <input type="text" name="full_name" placeholder="John Doe" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Contact Number</label>
                        <input type="text" name="contact_number" placeholder="0912 345 6789" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition" required>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Gender</label>
                    <select name="gender" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Address</label>
                    <textarea name="address" rows="2" placeholder="Street, City, Province" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Purpose</label>
                        <input type="text" name="purpose" placeholder="Meeting / Delivery" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Person to Visit</label>
                        <input type="text" name="person_to_visit" placeholder="Engr. Amen" class="w-full border-gray-100 border-2 bg-gray-50 p-2.5 rounded-xl focus:border-orange-500 focus:bg-white focus:outline-none transition" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-orange-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-orange-200 hover:bg-orange-700 hover:shadow-none transition-all transform active:scale-95 mt-4">
                    Confirm Check-In
                </button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800 });</script>
</body>
</html>