<?php
include 'db.php';
$id = intval($_GET['id']);
$data = $conn->query("SELECT * FROM visitors WHERE id = $id")->fetch_assoc();

$qr_content = "Visitor: " . $data['full_name'] . " | In: " . date('h:i A', strtotime($data['check_in_time']));
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_content);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Print ID — <?= htmlspecialchars($data['full_name']) ?></title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 500: '#f97316', 600: '#ea580c', 700: '#c2410c' },
                        surface: { 50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4', 800: '#1c1917', 900: '#0c0a09' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: none !important; display: flex !important; justify-content: center !important; align-items: center !important; }
            .badge-card { box-shadow: none !important; border: 1px solid #e7e5e4 !important; }
        }
    </style>
</head>
<body class="bg-surface-100 flex flex-col justify-center items-center min-h-screen p-4">

    <div class="badge-card bg-white w-[380px] rounded-3xl shadow-xl shadow-surface-900/5 overflow-hidden border border-surface-200/60 relative">
        <!-- Top accent -->
        <div class="h-2 bg-gradient-to-r from-brand-600 via-brand-500 to-brand-400"></div>

        <div class="px-8 pt-8 pb-7 text-center">
            <!-- Logo + org -->
            <div class="flex items-center justify-center gap-2.5 mb-6">
                <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-7 w-auto opacity-80">
                <span class="text-[10px] font-semibold text-surface-800/30 uppercase tracking-[0.15em]">Amen's Office</span>
            </div>

            <!-- Avatar -->
            <div class="w-28 h-28 bg-gradient-to-br from-brand-50 to-brand-100 border-4 border-white rounded-2xl mx-auto mb-5 flex items-center justify-center text-brand-600 text-4xl font-extrabold shadow-lg shadow-brand-500/10">
                <?= strtoupper(substr($data['full_name'], 0, 1)) ?>
            </div>

            <!-- Name + title -->
            <h2 class="text-2xl font-extrabold uppercase text-surface-900 tracking-tight leading-tight mb-1">
                <?= htmlspecialchars($data['full_name']) ?>
            </h2>
            <p class="text-brand-600 font-semibold text-[11px] uppercase tracking-[0.2em]">Official visitor</p>

            <!-- QR Code -->
            <div class="bg-surface-50 p-4 rounded-2xl inline-block my-5 border border-surface-200/40">
                <img src="<?= $qr_url ?>" alt="QR verification code" class="w-28 h-28">
                <p class="text-[9px] text-surface-800/30 mt-2 font-mono uppercase tracking-widest">Scan to verify</p>
            </div>

            <!-- Details -->
            <div class="text-left bg-surface-50 rounded-2xl p-5 space-y-3 border border-surface-200/40">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-semibold text-surface-800/35 uppercase tracking-wider">Host</span>
                    <span class="text-sm font-bold text-surface-800"><?= htmlspecialchars($data['person_to_visit']) ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-semibold text-surface-800/35 uppercase tracking-wider">Purpose</span>
                    <span class="text-sm font-bold text-surface-800"><?= htmlspecialchars($data['purpose_of_visit']) ?></span>
                </div>
                <div class="flex justify-between items-center border-t border-surface-200/40 pt-3">
                    <span class="text-[10px] font-semibold text-surface-800/35 uppercase tracking-wider">Check-in</span>
                    <span class="text-sm font-bold text-brand-600 tabular-nums"><?= date('h:i A', strtotime($data['check_in_time'])) ?></span>
                </div>
            </div>

            <p class="mt-5 text-[9px] text-surface-800/25 font-medium">Amen's Office Visitor Management System</p>
        </div>
    </div>

    <div class="mt-8 no-print flex gap-3">
        <button onclick="window.print()" class="bg-white text-brand-700 font-semibold px-7 py-3 rounded-2xl shadow-lg shadow-surface-900/5 border border-surface-200/60 hover:bg-surface-50 transition-all duration-200 active:scale-95 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print badge
        </button>
        <button onclick="window.close()" class="bg-surface-900 text-white font-semibold px-7 py-3 rounded-2xl shadow-lg hover:bg-surface-800 transition-all duration-200 active:scale-95 text-sm">
            Close
        </button>
    </div>

</body>
</html>
