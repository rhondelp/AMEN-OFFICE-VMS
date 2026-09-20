<?php
include 'db.php';

if (isset($_POST['block_visitor'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $conn->query("INSERT INTO blocklist (full_name, contact_number, reason) VALUES ('$name', '$contact', '$reason')");
    header("Location: security.php");
    exit;
}

if (isset($_GET['unblock_id'])) {
    $id = intval($_GET['unblock_id']);
    $conn->query("DELETE FROM blocklist WHERE id = $id");
    header("Location: security.php");
    exit;
}

$blocked_list = $conn->query("SELECT * FROM blocklist ORDER BY blocked_at DESC");
$total_blocked = $blocked_list->num_rows;
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
        .input-field { transition: all 0.2s ease; }
        .input-field:focus { border-color: #ef4444; background: #fff; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08); }
        .table-row { transition: background 0.15s ease; }
        .table-row:hover { background: #fef2f2; }
    </style>
    <title>Security Blocklist — Amen's VMS</title>
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
                <a href="dashboard.php" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-white/60 text-sm font-medium">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Dashboard
                </a>
                <a href="register.php" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-white/60 text-sm font-medium">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    New registration
                </a>

                <p class="text-[10px] font-semibold text-white/25 uppercase tracking-[0.15em] mt-8 mb-3 px-4">Security</p>
                <a href="security.php" class="sidebar-link active flex items-center gap-3 py-3 px-4 rounded-xl text-sm font-medium">
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
                    <h2 class="text-3xl font-bold text-surface-900 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        </div>
                        Security blocklist
                    </h2>
                    <p class="text-surface-800/50 text-sm mt-1">Manage visitors denied entry to the office</p>
                </div>
                <div class="bg-white px-5 py-3 rounded-2xl border border-surface-200/60">
                    <p class="text-[11px] text-surface-800/40 font-medium uppercase tracking-wider">Total blocked</p>
                    <p class="text-2xl font-extrabold text-red-500 tabular-nums"><?= $total_blocked ?></p>
                </div>
            </div>

            <!-- Block form -->
            <div class="bg-white rounded-2xl border border-surface-200/60 p-8 mb-8" data-aos="fade-up">
                <h3 class="text-lg font-bold text-surface-900 mb-1">Block a person</h3>
                <p class="text-surface-800/40 text-sm mb-6">Add someone to the blocklist to deny future entry</p>
                <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Full name</label>
                        <input type="text" name="full_name" placeholder="Juan Dela Cruz"
                               class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Contact number</label>
                        <input type="text" name="contact_number" placeholder="0912 345 6789"
                               class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Reason</label>
                        <input type="text" name="reason" placeholder="Unruly behavior / Threat / etc."
                               class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none" required>
                    </div>
                    <button type="submit" name="block_visitor" class="bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition-all duration-200 active:scale-[0.98] shadow-lg shadow-red-600/20 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Block access
                    </button>
                </form>
            </div>

            <!-- Blocked list table -->
            <div class="bg-white rounded-2xl border border-surface-200/60 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="p-6 pb-0">
                    <h3 class="text-lg font-bold text-surface-900 flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        Blocked visitors
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-surface-800/35 text-[10px] uppercase tracking-[0.12em] font-semibold border-b border-surface-200/40">
                                <th class="py-3.5 px-6">Name</th>
                                <th class="py-3.5 px-4">Contact</th>
                                <th class="py-3.5 px-4">Reason</th>
                                <th class="py-3.5 px-4">Date blocked</th>
                                <th class="py-3.5 px-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-200/40">
                            <?php if($total_blocked > 0): ?>
                            <?php while($b = $blocked_list->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-red-500 text-xs font-bold shrink-0">
                                            <?= strtoupper(substr($b['full_name'], 0, 2)) ?>
                                        </div>
                                        <span class="font-semibold text-surface-900 text-sm"><?= htmlspecialchars($b['full_name']) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-surface-800/60 tabular-nums"><?= htmlspecialchars($b['contact_number']) ?></td>
                                <td class="py-4 px-4">
                                    <span class="inline-block bg-red-50 text-red-600 px-3 py-1 rounded-lg text-[11px] font-semibold border border-red-100">
                                        <?= htmlspecialchars($b['reason']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-surface-800/40 tabular-nums">
                                    <?= isset($b['blocked_at']) ? date('M d, Y', strtotime($b['blocked_at'])) : '—' ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="security.php?unblock_id=<?= $b['id'] ?>"
                                       class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3.5 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-emerald-600 hover:text-white transition-all duration-200 active:scale-95 border border-emerald-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Unblock
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-3">
                                            <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <p class="text-surface-800/30 font-medium text-sm">No visitors blocklisted</p>
                                        <p class="text-surface-800/20 text-xs mt-1">The blocklist is empty — all visitors are clear for entry</p>
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
