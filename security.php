<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/mobile_nav.php';

if (isset($_POST['block_visitor'])) {
    $name    = trim($_POST['full_name'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    $reason  = trim($_POST['reason'] ?? '');

    query(
        "INSERT INTO blocklist (full_name, contact_number, reason) VALUES (?, ?, ?)",
        [$name, $contact, $reason], 'sss'
    );
    redirect('security.php');
}

if (isset($_GET['unblock_id'])) {
    $id = intval($_GET['unblock_id']);
    query("DELETE FROM blocklist WHERE id = ?", [$id], 'i');
    redirect('security.php');
}

$blocked_list = query("SELECT * FROM blocklist ORDER BY blocked_at DESC");
$total_blocked = $blocked_list ? $blocked_list->num_rows : 0;

render_head('Security Blocklist');
render_sidebar('security.php');
?>

<main class="flex-1 p-6 lg:p-10 min-w-0 pb-24 lg:pb-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-surface-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                Security blocklist
            </h2>
            <p class="text-surface-800/45 text-sm mt-1">Manage visitors denied entry to the office</p>
        </div>
        <div class="bg-white px-5 py-3 rounded-2xl border border-surface-200/60">
            <p class="text-[11px] text-surface-800/35 font-medium uppercase tracking-wider">Total blocked</p>
            <p class="text-2xl font-extrabold text-red-500 tabular-nums"><?= $total_blocked ?></p>
        </div>
    </div>

    <!-- Block form -->
    <div class="bg-white rounded-2xl border border-surface-200/60 p-6 lg:p-8 mb-8" data-aos="fade-up">
        <h3 class="text-lg font-bold text-surface-900 mb-1">Block a person</h3>
        <p class="text-surface-800/35 text-sm mb-6">Add someone to the blocklist to deny future entry</p>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Full name</label>
                <input type="text" name="full_name" placeholder="Juan Dela Cruz" required
                       class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Contact number</label>
                <input type="text" name="contact_number" placeholder="0912 345 6789" required
                       class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Reason</label>
                <input type="text" name="reason" placeholder="Unruly behavior / Threat / etc." required
                       class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none">
            </div>
            <button type="submit" name="block_visitor" class="bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition-all active:scale-[0.98] shadow-lg shadow-red-600/20 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                Block access
            </button>
        </form>
    </div>

    <!-- Blocked list table -->
    <div class="bg-white rounded-2xl border border-surface-200/60 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="p-6 pb-0">
            <h3 class="text-lg font-bold text-surface-900">Blocked visitors</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-surface-800/30 text-[10px] uppercase tracking-[0.12em] font-semibold border-b border-surface-200/40">
                        <th class="py-3.5 px-6">Name</th>
                        <th class="py-3.5 px-4">Contact</th>
                        <th class="py-3.5 px-4">Reason</th>
                        <th class="py-3.5 px-4">Date blocked</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200/40">
                    <?php if ($total_blocked > 0): ?>
                        <?php while ($b = $blocked_list->fetch_assoc()): ?>
                            <tr class="table-row">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-red-500 text-xs font-bold shrink-0">
                                            <?= strtoupper(mb_substr($b['full_name'], 0, 2)) ?>
                                        </div>
                                        <span class="font-semibold text-surface-900 text-sm"><?= sanitize($b['full_name']) ?></span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-surface-800/55 tabular-nums"><?= sanitize($b['contact_number']) ?></td>
                                <td class="py-4 px-4">
                                    <span class="inline-block bg-red-50 text-red-600 px-3 py-1 rounded-lg text-[11px] font-semibold border border-red-100">
                                        <?= sanitize($b['reason']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-surface-800/35 tabular-nums">
                                    <?= $b['blocked_at'] ?? '—' ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="?unblock_id=<?= $b['id'] ?>"
                                       class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3.5 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-emerald-600 hover:text-white transition-all active:scale-95 border border-emerald-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Unblock
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-surface-800/25 font-medium text-sm">No visitors blocklisted</p>
                                <p class="text-surface-800/15 text-xs mt-1">The blocklist is empty — all visitors are clear for entry</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php render_mobile_nav('security.php'); ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>
