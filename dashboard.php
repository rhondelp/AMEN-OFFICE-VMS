<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/mobile_nav.php';

// Handle checkout
if (isset($_GET['checkout_id'])) {
    $id = intval($_GET['checkout_id']);
    query("UPDATE visitors SET check_out_time = NOW(), status = 'Checked Out' WHERE id = ?", [$id], 'i');
    redirect('dashboard.php');
}

// Search
$search = $_GET['search'] ?? '';
$searchParam = "%{$search}%";
$visitors = query(
    "SELECT * FROM visitors WHERE full_name LIKE ? OR person_to_visit LIKE ? ORDER BY check_in_time DESC",
    [$searchParam, $searchParam], 'ss'
);

// Stats
$total_today  = query_count("SELECT COUNT(*) as count FROM visitors WHERE DATE(check_in_time) = CURDATE()");
$inside_now   = query_count("SELECT COUNT(*) as count FROM visitors WHERE status = 'Inside'");
$frequent     = query_single("SELECT full_name, COUNT(*) as visits FROM visitors GROUP BY full_name ORDER BY visits DESC LIMIT 1");
$total_blocked = query_count("SELECT COUNT(*) as count FROM blocklist");
$male_count   = query_count("SELECT COUNT(*) as count FROM visitors WHERE gender = 'Male'");
$female_count = query_count("SELECT COUNT(*) as count FROM visitors WHERE gender = 'Female'");

render_head('Dashboard');
render_sidebar('dashboard.php');
?>

<main class="flex-1 p-6 lg:p-10 min-w-0 pb-24 lg:pb-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-surface-900 tracking-tight">Visitor analytics</h2>
            <p class="text-surface-800/45 text-sm mt-1">Overview of today's activity</p>
        </div>
        <div class="bg-white px-5 py-3 rounded-2xl border border-surface-200/60">
            <p class="text-[11px] text-surface-800/35 font-medium uppercase tracking-wider"><?= date('l, F j, Y') ?></p>
            <p class="text-lg font-bold text-surface-900 tabular-nums"><?= date('h:i A') ?></p>
        </div>
    </div>

    <!-- Primary stats -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
        <?php
        $stats = [
            ['label' => "Today's visitors", 'value' => $total_today, 'color' => 'brand',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ['label' => 'Currently inside', 'value' => $inside_now, 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ['label' => 'Most frequent', 'value' => $frequent['full_name'] ?? '—', 'suffix' => ($frequent['visits'] ?? 0) . ' visits', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>'],
        ];
        foreach ($stats as $i => $s): ?>
            <div class="stat-card bg-white p-5 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="<?= ($i + 1) * 100 ?>">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider"><?= $s['label'] ?></p>
                    <div class="w-8 h-8 rounded-lg bg-<?= $s['color'] ?>-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-<?= $s['color'] ?>-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $s['icon'] ?></svg>
                    </div>
                </div>
                <?php if (isset($s['suffix'])): ?>
                    <h3 class="text-base font-bold text-surface-900 truncate"><?= $s['value'] ?></h3>
                    <p class="text-xs text-surface-800/35 mt-0.5"><?= $s['suffix'] ?></p>
                <?php else: ?>
                    <h3 class="text-3xl font-extrabold text-surface-900 tabular-nums"><?= $s['value'] ?></h3>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Secondary stats -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        <?php
        $secondary = [
            ['label' => 'Blocklisted', 'value' => $total_blocked, 'text' => 'red-500', 'bg' => 'red-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>'],
            ['label' => 'Male', 'value' => $male_count, 'text' => 'surface-900', 'bg' => 'blue-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            ['label' => 'Female', 'value' => $female_count, 'text' => 'surface-900', 'bg' => 'pink-50', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
        ];
        foreach ($secondary as $i => $s): ?>
            <div class="stat-card bg-white p-5 rounded-2xl border border-surface-200/60" data-aos="fade-down" data-aos-delay="<?= ($i + 4) * 100 ?>">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider"><?= $s['label'] ?></p>
                    <div class="w-8 h-8 rounded-lg bg-<?= $s['bg'] ?> flex items-center justify-center">
                        <svg class="w-4 h-4 text-<?= $s['text'] ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $s['icon'] ?></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-extrabold text-<?= $s['text'] ?> tabular-nums"><?= $s['value'] ?></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Visitor logs table -->
    <div class="bg-white rounded-2xl border border-surface-200/60 overflow-hidden" data-aos="fade-up">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-6 pb-0 gap-4">
            <h2 class="text-lg font-bold text-surface-900">Recent visitor logs</h2>
            <form method="GET" class="relative w-full md:w-80">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-800/25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" placeholder="Search name or host..." value="<?= sanitize($search) ?>"
                       class="w-full bg-surface-50 border border-surface-200/60 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-surface-800/30 text-[10px] uppercase tracking-[0.12em] font-semibold border-b border-surface-200/40">
                        <th class="py-3.5 px-6">Visitor</th>
                        <th class="py-3.5 px-4 text-center">Time in</th>
                        <th class="py-3.5 px-4 text-center">Time out</th>
                        <th class="py-3.5 px-4 text-center">Purpose</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200/40">
                    <?php if ($visitors && $visitors->num_rows > 0): ?>
                        <?php while ($row = $visitors->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-surface-900 text-sm"><?= sanitize($row['full_name']) ?></div>
                                    <div class="text-[11px] text-surface-800/35 mt-0.5">Host: <?= sanitize($row['person_to_visit']) ?></div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block bg-brand-50 text-brand-700 px-3 py-1 rounded-lg text-[11px] font-semibold tabular-nums">
                                        <?= date('h:i A', strtotime($row['check_in_time'])) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <?php if ($row['check_out_time']): ?>
                                        <span class="inline-block bg-surface-100 text-surface-800/50 px-3 py-1 rounded-lg text-[11px] font-semibold tabular-nums">
                                            <?= date('h:i A', strtotime($row['check_out_time'])) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-brand-500 text-[11px] font-semibold inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 bg-brand-500 rounded-full animate-pulse"></span>Active
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-sm text-surface-800/60"><?= sanitize($row['purpose_of_visit']) ?></span>
                                </td>
                                <td class="py-4 px-4">
                                    <?php if ($row['status'] === 'Inside'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>Inside
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-surface-100 text-surface-800/35">Out</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <?php if ($row['status'] === 'Inside'): ?>
                                        <div class="flex justify-end gap-2">
                                            <a href="?checkout_id=<?= $row['id'] ?>" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-red-600 hover:text-white transition-all active:scale-95">Check out</a>
                                            <a href="badge.php?id=<?= $row['id'] ?>" target="_blank" class="bg-brand-50 text-brand-700 px-3 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-brand-600 hover:text-white transition-all active:scale-95">ID pass</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-surface-800/20 text-[11px] italic">Done</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <svg class="w-10 h-10 text-surface-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-surface-800/30 font-medium text-sm">No visitors found</p>
                                <p class="text-surface-800/20 text-xs mt-1"><?= $search ? 'Try a different search term' : 'Visitors will appear here once registered' ?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php render_mobile_nav('dashboard.php'); ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>
