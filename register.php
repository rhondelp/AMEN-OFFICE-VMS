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
        $error_message = "ACCESS DENIED — This visitor is on the blocklist. Reason: " . htmlspecialchars($block_data['reason']);
    } 
    else if ($check_inside && $check_inside->num_rows > 0) {
        $error_message = "DUPLICATE ENTRY — This visitor is already checked-in and currently inside the office.";
    } 
    else {
        $gender  = mysqli_real_escape_string($conn, $_POST['gender']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
        $host    = mysqli_real_escape_string($conn, $_POST['person_to_visit']);

        $sql = "INSERT INTO visitors (full_name, contact_number, gender, address, purpose_of_visit, person_to_visit, status) 
                VALUES ('$name', '$contact', '$gender', '$address', '$purpose', '$host', 'Inside')";

        if ($conn->query($sql)) {
            $success_message = "Visitor registered successfully.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Visitor — Amen's VMS</title>
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
                            800: '#1c1917', 900: '#0c0a09',
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
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.08);
        }
    </style>
</head>
<body class="bg-surface-100 min-h-screen flex items-center justify-center p-6">
    <div class="grain"></div>

    <div class="max-w-5xl w-full bg-white shadow-xl shadow-surface-900/5 rounded-3xl overflow-hidden flex flex-col md:flex-row border border-surface-200/60" data-aos="zoom-in" data-aos-delay="100">
        <!-- Left panel -->
        <div class="md:w-[38%] bg-surface-900 p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand-500 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-brand-600 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-9 w-auto opacity-80">
                    <div>
                        <h2 class="text-lg font-bold tracking-tight">Amen's Office</h2>
                        <p class="text-[9px] text-white/30 font-medium uppercase tracking-[0.15em]">Visitor Management</p>
                    </div>
                </div>

                <h3 class="text-3xl font-extrabold leading-tight tracking-tight mb-4" style="text-wrap: balance;">Visitor check-in</h3>
                <p class="text-white/50 text-sm leading-relaxed">Provide accurate details for security purposes. All entries are logged with timestamps.</p>
            </div>

            <div class="relative z-10 mt-10">
                <a href="index.php" class="inline-flex items-center gap-2 text-xs font-semibold bg-white/10 hover:bg-white/15 text-white/70 hover:text-white py-2.5 px-5 rounded-xl transition-all duration-200 border border-white/10">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to home
                </a>
            </div>
        </div>

        <!-- Form panel -->
        <div class="md:w-[62%] p-10">
            <h2 class="text-2xl font-bold text-surface-900 tracking-tight mb-1">New visitor registration</h2>
            <p class="text-surface-800/40 text-sm mb-8">Fill in the visitor's details below</p>

            <?php if($error_message): ?>
                <div class="bg-red-50 border border-red-200/60 text-red-700 p-4 mb-6 rounded-2xl text-sm flex items-start gap-3" data-aos="fade-down">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <div>
                        <p class="font-semibold mb-0.5">Security alert</p>
                        <p class="text-red-600/80 text-xs leading-relaxed"><?= $error_message ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($success_message): ?>
                <div class="bg-emerald-50 border border-emerald-200/60 text-emerald-700 p-4 mb-6 rounded-2xl text-sm flex items-start gap-3" data-aos="fade-down">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold mb-0.5">Registration complete</p>
                        <p class="text-emerald-600/80 text-xs">
                            <?= $success_message ?>
                            <a href="dashboard.php" class="underline font-medium ml-1 hover:text-emerald-800">View in dashboard</a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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
                </div>

                <div>
                    <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Gender</label>
                    <select name="gender" class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none appearance-none cursor-pointer">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Address</label>
                    <textarea name="address" rows="2" placeholder="Street, City, Province"
                              class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Purpose of visit</label>
                        <input type="text" name="purpose" placeholder="Meeting / Delivery / Inquiry"
                               class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-semibold text-surface-800/40 uppercase tracking-wider block mb-2">Person to visit</label>
                        <input type="text" name="person_to_visit" placeholder="Engr. Amen"
                               class="input-field w-full border border-surface-200/60 bg-surface-50 px-4 py-3 rounded-xl text-sm outline-none" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-600 text-white py-4 rounded-2xl font-semibold shadow-lg shadow-brand-600/20 hover:bg-brand-700 hover:shadow-brand-600/30 transition-all duration-200 active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Confirm check-in
                </button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });</script>
</body>
</html>
