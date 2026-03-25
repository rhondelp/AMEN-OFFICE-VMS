<?php 
include 'db.php';

// Handle Check-out action
if (isset($_GET['checkout_id'])) {
    $id = $_GET['checkout_id'];
    $conn->query("UPDATE visitors SET check_out_time = NOW(), status = 'Checked Out' WHERE id = $id");
    header("Location: dashboard.php");
}

// Search Logic
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM visitors WHERE full_name LIKE '%$search%' OR person_to_visit LIKE '%$search%' ORDER BY check_in_time DESC";
$result = $conn->query($query);

// Dashboard Stats
$total_today = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE DATE(check_in_time) = CURDATE()")->fetch_assoc()['count'];
$inside_now = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE status = 'Inside'")->fetch_assoc()['count'];
$frequent = $conn->query("SELECT full_name, COUNT(*) as visits FROM visitors GROUP BY full_name ORDER BY visits DESC LIMIT 1")->fetch_assoc();

// NEW STATS: Blocklist and Gender Count
$total_blocked = $conn->query("SELECT COUNT(*) as count FROM blocklist")->fetch_assoc()['count'];
$male_count = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE gender = 'Male'")->fetch_assoc()['count'];
$female_count = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE gender = 'Female'")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>body { font-family: 'Poppins'; }</style>
    <title>Dashboard - Amen's VMS</title>
</head>
<body class="bg-orange-500 min-h-screen">

    <div class="flex">
        <div class="w-72 h-screen bg-slate-900 text-white p-6 sticky top-0 flex flex-col shadow-2xl">
            <h1 class="text-2xl font-bold mb-10 text-orange-500">Amen's Office <span class="text-white">VMS</span></h1>
            
            <nav class="space-y-2 flex-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Main Menu</p>
                <a href="index.php" class="flex items-center space-x-3 py-3 px-4 hover:bg-slate-800 rounded-xl transition group">
                    <span>🏠</span> <span class="group-hover:text-orange-400">Home Page</span>
                </a>
                <a href="dashboard.php" class="flex items-center space-x-3 py-3 px-4 bg-orange-600 rounded-xl transition shadow-lg shadow-orange-900/50">
                    <span>📊</span> <span>Dashboard</span>
                </a>
                <a href="register.php" class="flex items-center space-x-3 py-3 px-4 hover:bg-slate-800 rounded-xl transition group">
                    <span>📝</span> <span class="group-hover:text-orange-400">New Registration</span>
                </a>
                
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mt-8 mb-4">Admin & Security</p>
                <a href="security.php" class="flex items-center space-x-3 py-3 px-4 hover:bg-red-900/40 rounded-xl transition group border border-transparent hover:border-red-800">
                    <span>🚫</span> <span class="group-hover:text-red-400">Security Blocklist</span>
                </a>
            </nav>

            <div class="pt-6 border-t border-slate-800 text-xs text-gray-500">
                Logged in as Administrator
            </div>
        </div>

        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-white drop-shadow-md">Visitor Analytics</h2>
                <div class="text-white text-right">
                    <p class="text-sm opacity-80"><?= date('l, F j, Y') ?></p>
                    <p class="text-xl font-bold"><?= date('h:i A') ?></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-blue-500" data-aos="fade-down" data-aos-delay="100">
                    <p class="text-gray-500 text-xs font-bold uppercase">Total Visitors Today</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-2"><?= $total_today ?></h3>
                </div>
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-green-500" data-aos="fade-down" data-aos-delay="200">
                    <p class="text-gray-500 text-xs font-bold uppercase">Currently Inside</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-2"><?= $inside_now ?></h3>
                </div>
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-orange-500" data-aos="fade-down" data-aos-delay="300">
                    <p class="text-gray-500 text-xs font-bold uppercase">Most Frequent</p>
                    <h3 class="text-xl font-black text-gray-800 mt-2 truncate"><?= $frequent['full_name'] ?? 'None' ?></h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-red-600" data-aos="fade-down" data-aos-delay="400">
                    <p class="text-gray-500 text-xs font-bold uppercase">Total Blocklisted</p>
                    <h3 class="text-4xl font-black text-red-600 mt-2"><?= $total_blocked ?></h3>
                </div>
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-indigo-500" data-aos="fade-down" data-aos-delay="500">
                    <p class="text-gray-500 text-xs font-bold uppercase">Male Visitors</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-2"><?= $male_count ?> <span class="text-sm font-normal text-gray-400">Total</span></h3>
                </div>
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-xl border-b-4 border-pink-500" data-aos="fade-down" data-aos-delay="600">
                    <p class="text-gray-500 text-xs font-bold uppercase">Female Visitors</p>
                    <h3 class="text-4xl font-black text-gray-800 mt-2"><?= $female_count ?> <span class="text-sm font-normal text-gray-400">Total</span></h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-2xl p-8 overflow-hidden" data-aos="fade-up">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="bg-orange-100 text-orange-600 p-2 rounded-lg">📋</span>
                        Recent Visitor Logs
                    </h2>
                    <form method="GET" class="relative w-full md:w-96">
                        <input type="text" name="search" placeholder="Search name or host..." value="<?= htmlspecialchars($search) ?>" 
                               class="w-full bg-gray-100 border-none rounded-2xl px-6 py-3 text-sm focus:ring-2 focus:ring-orange-500 transition">
                        <button type="submit" class="absolute right-2 top-2 bg-orange-600 text-white px-4 py-1.5 rounded-xl text-xs font-bold hover:bg-orange-700">Search</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-gray-100">
                                <th class="py-4 px-4">Visitor Info</th>
                                <th class="py-4 px-2 text-center">Time In</th>
                                <th class="py-4 px-2 text-center">Time Out</th>
                                <th class="py-4 px-2">Status</th>
                                <th class="py-4 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 divide-y divide-gray-50">
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="group hover:bg-orange-50/50 transition-all">
                                <td class="py-5 px-4">
                                    <div class="font-bold text-gray-900 group-hover:text-orange-600 transition"><?= $row['full_name'] ?></div>
                                    <div class="text-xs text-gray-400">Host: <?= $row['person_to_visit'] ?></div>
                                </td>
                                
                                <td class="py-5 px-2 text-center">
                                    <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-xl text-[11px] font-bold border border-blue-100">
                                        <?= date('h:i A', strtotime($row['check_in_time'])) ?>
                                    </span>
                                </td>

                                <td class="py-5 px-2 text-center">
                                    <?php if($row['check_out_time']): ?>
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-xl text-[11px] font-bold border border-gray-200">
                                            <?= date('h:i A', strtotime($row['check_out_time'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-orange-400 text-xs font-medium animate-pulse italic">Active Session</span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-5 px-2">
                                    <?php if($row['status'] == 'Inside'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-ping"></span> Inside
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-gray-100 text-gray-500">Checked Out</span>
                                    <?php endif; ?>
                                </td>

                                <td class="py-5 px-2 text-right">
                                    <?php if($row['status'] == 'Inside'): ?>
                                        <div class="flex justify-end gap-2">
                                            <a href="dashboard.php?checkout_id=<?= $row['id'] ?>" class="bg-red-50 text-red-600 px-3 py-2 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition">Check Out</a>
                                            <a href="badge.php?id=<?= $row['id'] ?>" target="_blank" class="bg-blue-50 text-blue-600 px-3 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition">ID Pass</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-300 text-xs italic">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>