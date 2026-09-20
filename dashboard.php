<?php 
include 'db.php';

if (isset($_GET['checkout_id'])) {
    $id = intval($_GET['checkout_id']);
    $conn->query("UPDATE visitors SET check_out_time = NOW(), status = 'Checked Out' WHERE id = $id");
    header("Location: dashboard.php");
    exit;
}

$search = $_GET['search'] ?? '';
$searchSafe = mysqli_real_escape_string($conn, $search);
$query = "SELECT * FROM visitors WHERE full_name LIKE '%$searchSafe%' OR person_to_visit LIKE '%$searchSafe%' ORDER BY check_in_time DESC";
$result = $conn->query($query);

$total_today = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE DATE(check_in_time) = CURDATE()")->fetch_assoc()['count'];
$inside_now = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE status = 'Inside'")->fetch_assoc()['count'];
$frequent = $conn->query("SELECT full_name, COUNT(*) as visits FROM visitors GROUP BY full_name ORDER BY visits DESC LIMIT 1")->fetch_assoc();
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { outfit: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74',
                            400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c',
                        },
                        surface: {
                            50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4',
                            700: '#292524', 800: '#1c1917', 900: '#0c0a09',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .grain {
            position: fixed; inset: 0; pointer-events: none; z-index: 9999; opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); }
        .sidebar-link.active { background: rgba(249, 115, 22, 0.15); color: #fb923c; }
        .stat-card { transition: all 0.25s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 12px 40px -8px rgba(0,0,0,0.08); }
        .table-row { transition: background 0.15s ease; }
        .table-row:hover { background: #fff7ed; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d6d3d1; border-radius: 3px; }
    </style>
    <title>Dashboard — Amen's VMS</title>
</head>
<body class="bg-surface-100 min-h-screen">
    <div class="grain"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-surface-900 text-white p-6 sticky top-0 h-screen flex flex-col shrink-0">
            <div class="flex items-center gap-3 mb-10">
                <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-9 w-auto opacity-80">
                <div>
                    <h1 class="text-lg font-bold tracking-tight">Amen's Office</h1>
                    <p class="text-[10px] text-white/30 font-medium uppercase tracking-widest">Visitor Management</p>
                </div>
            </div>

            <nav class="space-y-1 flex-1">
                <p class="text-[10px] font-semibold text-white/25 uppercase tracking-[0.15em] mb-3 px-4">Main</p>
                <a href="index.php" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-white/60 text-sm font-medium">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="dashboard.php" class="sidebar-link active flex items-center gap-3 py-3 px-4 rounded-xl text-sm font-medium">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Dashboard
                </a>
                <a href="register.php" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-white/60 text-sm font-medium">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    New registration
                </a>

                <p class="text-[10px] font-semibold text-white/25 uppercase tracking-[0.15em] mt-8 mb-3 px-4">Security</p>
                <a href="security.php" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-white/60 text-sm font-medium hover:text-red-400 hover:bg-red-500/10">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    Blocklist
                </a>
            </nav>

            <div class="pt-5 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-600/20 text-brand-400 flex items-center justify-center text-xs font-bold">A</div>
                    <div>
                        <p class="text-xs font-semibold text-white/80">Administrator</p>
                        <p class="text-[10px] text-white/30">Logged in</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-8 lg:p-10 min-w-0">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-surface-900 tracking-tight">Visitor analytics</h2>
                    <p class="text-surface-800/50 text-sm mt-1">Overview of today's activity</p>
                </div>
                <div class="text-right bg-white px-5 py-3 rounded-2xl border border-surface-200/60">
                    <p class="text-[11px] text-surface-800/40 font-medium uppercase tracking-wider"><?= date('l, F j, Y') ?></p>
                    <p class="text-lg font-bold text-surface-900 tabular-nums"><?= date('h:i A') ?></p>
                </div>
            </div>

            <!-- Stat cards row 1 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-5">
                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Today's visitors</p>
                        <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-extrabold text-surface-900 tabular-nums"><?= $total_today ?></h3>
                </div>

                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Currently inside</p>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-extrabold text-surface-900 tabular-nums"><?= $inside_now ?></h3>
                </div>

                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Most frequent</p>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 truncate"><?= $frequent['full_name'] ?? 'No data yet' ?></h3>
                    <p class="text-xs text-surface-800/40 mt-0.5"><?= $frequent['visits'] ?? 0 ?> visits recorded</p>
                </div>
            </div>

            <!-- Stat cards row 2 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="400">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Blocklisted</p>
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-extrabold text-red-500 tabular-nums"><?= $total_blocked ?></h3>
                </div>

                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="500">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Male visitors</p>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-extrabold text-surface-900 tabular-nums"><?= $male_count ?></h3>
                </div>

                <div class="stat-card bg-white p-6 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="600">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider">Female visitors</p>
                        <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-4xl font-extrabold text-surface-900 tabular-nums"><?= $female_count ?></h3>
                </div>
            </div>

            <!-- Visitor logs table -->
            <div class="bg-white rounded-2xl border border-surface-200/60 overflow-hidden" data-aos="fade-up">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 pb-0 gap-4">
                    <h2 class="text-lg font-bold text-surface-900 flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Recent visitor logs
                    </h2>
                    <form method="GET" class="relative w-full md:w-80">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-800/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Search name or host..." value="<?= htmlspecialchars($search) ?>"
                               class="w-full bg-surface-50 border border-surface-200/60 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all duration-200">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-surface-800/35 text-[10px] uppercase tracking-[0.12em] font-semibold border-b border-surface-200/40">
                                <th class="py-3.5 px-6">Visitor</th>
                                <th class="py-3.5 px-4 text-center">Time in</th>
                                <th class="py-3.5 px-4 text-center">Time out</th>
                                <th class="py-3.5 px-4 text-center">Purpose</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-200/40">
                            <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-surface-900 text-sm"><?= htmlspecialchars($row['full_name']) ?></div>
                                    <div class="text-[11px] text-surface-800/40 mt-0.5">Host: <?= htmlspecialchars($row['person_to_visit']) ?></div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block bg-brand-50 text-brand-700 px-3 py-1 rounded-lg text-[11px] font-semibold tabular-nums">
                                        <?= date('h:i A', strtotime($row['check_in_time'])) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <?php if($row['check_out_time']): ?>
                                        <span class="inline-block bg-surface-100 text-surface-800/60 px-3 py-1 rounded-lg text-[11px] font-semibold tabular-nums">
                                            <?= date('h:i A', strtotime($row['check_out_time'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-brand-500 text-[11px] font-semibold flex items-center justify-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-brand-500 rounded-full animate-pulse"></span>
                                            Active
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-sm text-surface-800/70"><?= htmlspecialchars($row['purpose_of_visit']) ?></span>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if($row['status'] == 'Inside'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            Inside
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-surface-100 text-surface-800/40">Out</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <?php if($row['status'] == 'Inside'): ?>
                                        <div class="flex justify-end gap-2">
                                            <a href="dashboard.php?checkout_id=<?= $row['id'] ?>" class="bg-red-50 text-red-600 px-3.5 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-red-600 hover:text-white transition-all duration-200 active:scale-95">Check out</a>
                                            <a href="badge.php?id=<?= $row['id'] ?>" target="_blank" class="bg-brand-50 text-brand-700 px-3.5 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-brand-600 hover:text-white transition-all duration-200 active:scale-95">ID pass</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-surface-800/25 text-[11px] italic">Done</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-surface-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <p class="text-surface-800/30 font-medium text-sm">No visitors found</p>
                                        <p class="text-surface-800/20 text-xs mt-1"><?= $search ? 'Try a different search term' : 'Visitors will appear here once registered' ?></p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>
