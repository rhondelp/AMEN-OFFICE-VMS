<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/mobile_nav.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['full_name'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    $gender  = $_POST['gender'] ?? 'Male';
    $address = trim($_POST['address'] ?? '');
    $purpose = trim($_POST['purpose'] ?? '');
    $host    = trim($_POST['person_to_visit'] ?? '');

    $blocked = query_single(
        "SELECT reason FROM blocklist WHERE full_name = ? OR contact_number = ? LIMIT 1",
        [$name, $contact], 'ss'
    );

    $already_inside = query_single(
        "SELECT id FROM visitors WHERE (full_name = ? OR contact_number = ?) AND status = 'Inside' LIMIT 1",
        [$name, $contact], 'ss'
    );

    if ($blocked) {
        $error = "ACCESS DENIED — This visitor is on the blocklist. Reason: " . sanitize($blocked['reason']);
    } elseif ($already_inside) {
        $error = "DUPLICATE ENTRY — This visitor is already checked-in and currently inside.";
    } else {
        $ok = query(
            "INSERT INTO visitors (full_name, contact_number, gender, address, purpose_of_visit, person_to_visit, status) VALUES (?, ?, ?, ?, ?, ?, 'Inside')",
            [$name, $contact, $gender, $address, $purpose, $host], 'ssssss'
        );
        if ($ok) {
            $success = "Visitor registered successfully.";
        }
    }
}

render_head('Register Visitor');
?>

<body class="bg-surface-100 min-h-screen flex items-center justify-center p-4 lg:p-6">
<div class="grain"></div>

<div class="max-w-5xl w-full bg-white shadow-xl shadow-surface-900/5 rounded-3xl overflow-hidden flex flex-col md:flex-row border border-surface-200/60" data-aos="zoom-in" data-aos-delay="100">
    <!-- Left panel -->
    <div class="md:w-[38%] bg-surface-900 p-8 lg:p-10 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-40 h-40 bg-brand-500 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-brand-600 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        </div>
        <div class="relative z-10">
            <a href="index.php" class="flex items-center gap-2 mb-8">
                <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-9 w-auto opacity-80">
                <div>
                    <h2 class="text-lg font-bold tracking-tight">Amen's Office</h2>
                    <p class="text-[9px] text-white/30 font-medium uppercase tracking-[0.15em]">Visitor Management</p>
                </div>
            </a>
            <h3 class="text-3xl font-extrabold leading-tight tracking-tight mb-4" style="text-wrap:balance;">Visitor check-in</h3>
            <p class="text-white/45 text-sm leading-relaxed">Provide accurate details for security purposes. All entries are logged with timestamps.</p>
        </div>
        <div class="relative z-10 mt-10">
            <a href="index.php" class="inline-flex items-center gap-2 text-xs font-semibold bg-white/10 hover:bg-white/15 text-white/60 hover:text-white py-2.5 px-5 rounded-xl transition-all border border-white/10">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to home
            </a>
        </div>
    </div>

    <!-- Form panel -->
    <div class="md:w-[62%] p-8 lg:p-10">
        <h2 class="text-2xl font-bold text-surface-900 tracking-tight mb-1">New visitor registration</h2>
        <p class="text-surface-800/40 text-sm mb-8">Fill in the visitor's details below</p>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200/60 text-red-700 p-4 mb-6 rounded-2xl text-sm flex items-start gap-3" data-aos="fade-down">
                <svg class="w-5 h-5 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                <div><p class="font-semibold mb-0.5">Security alert</p><p class="text-red-600/70 text-xs leading-relaxed"><?= $error ?></p></div>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-emerald-50 border border-emerald-200/60 text-emerald-700 p-4 mb-6 rounded-2xl text-sm flex items-start gap-3" data-aos="fade-down">
                <svg class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-semibold mb-0.5">Registration complete</p>
                    <p class="text-emerald-600/70 text-xs"><?= $success ?> <a href="dashboard.php" class="underline font-medium hover:text-emerald-800">View in dashboard</a></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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
            </div>

            <div>
                <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Gender</label>
                <select name="gender" class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none appearance-none cursor-pointer">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Address</label>
                <textarea name="address" rows="2" placeholder="Street, City, Province"
                          class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none resize-none"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Purpose of visit</label>
                    <input type="text" name="purpose" placeholder="Meeting / Delivery / Inquiry" required
                           class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none">
                </div>
                <div>
                    <label class="text-[11px] font-semibold text-surface-800/35 uppercase tracking-wider block mb-2">Person to visit</label>
                    <input type="text" name="person_to_visit" placeholder="Engr. Amen" required
                           class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none">
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-600 text-white py-3.5 rounded-2xl font-semibold shadow-lg shadow-brand-600/20 hover:bg-brand-700 transition-all active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Confirm check-in
            </button>
        </form>
    </div>
</div>

<?php render_mobile_nav('register'); ?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>
