<?php
include 'db.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM visitors WHERE id = $id")->fetch_assoc();


$qr_content = "Visitor: " . $data['full_name'] . " | In: " . date('h:i A', strtotime($data['check_in_time']));
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_content);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <title>Print ID - <?= $data['full_name'] ?></title>
    <style>

        @media print { 
            .no-print { 
                display: none !important; 
            } 
            
            /* Optional: Centers the card on the printed page */
            body { 
                background: none !important; 
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
            }

            .badge-card {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
            }
        }
    </style>
</head>
<body class="bg-orange-500 flex flex-col justify-center items-center min-h-screen p-4">

    <div class="badge-card bg-white w-[400px] rounded-[2.5rem] shadow-2xl overflow-hidden border-t-[12px] border-orange-600 relative">
        
        <div class="bg-orange-600 h-24 w-full absolute top-0 left-0 clip-path"></div>

        <div class="relative pt-10 pb-8 px-8 text-center">
            <div class="w-32 h-32 bg-orange-100 border-4 border-white rounded-full mx-auto mb-4 flex items-center justify-center text-orange-600 text-5xl font-black shadow-lg">
                <?= substr($data['full_name'], 0, 1) ?>
            </div>

            <h2 class="text-3xl font-extrabold uppercase text-slate-800 tracking-tight leading-tight">
                <?= $data['full_name'] ?>
            </h2>
            <p class="text-orange-600 font-bold tracking-[0.2em] text-sm mb-6">OFFICIAL VISITOR</p>
            
            <div class="bg-gray-50 p-4 rounded-3xl inline-block mb-6 border border-gray-100">
                <img src="<?= $qr_url ?>" alt="QR Code" class="w-32 h-32">
                <p class="text-[10px] text-gray-400 mt-2 font-mono uppercase tracking-widest">Verify Access</p>
            </div>

            <div class="text-left bg-orange-50 rounded-2xl p-5 space-y-3 border border-orange-100">
                <div class="flex justify-between">
                    <span class="text-[10px] font-bold text-orange-400 uppercase">To Visit</span>
                    <span class="text-sm font-bold text-slate-700"><?= $data['person_to_visit'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[10px] font-bold text-orange-400 uppercase">Purpose</span>
                    <span class="text-sm font-bold text-slate-700"><?= $data['purpose_of_visit'] ?></span>
                </div>
                <div class="flex justify-between border-t border-orange-200 pt-2">
                    <span class="text-[10px] font-bold text-orange-400 uppercase">Check-In Time</span>
                    <span class="text-sm font-bold text-orange-600"><?= date('h:i A', strtotime($data['check_in_time'])) ?></span>
                </div>
            </div>

            <p class="mt-6 text-[10px] text-gray-400 font-medium">Amen's Office Visitor Management System</p>
        </div>
    </div>

    <div class="mt-8 no-print flex gap-4">
        <button onclick="window.print()" class="bg-white text-orange-600 font-bold px-8 py-3 rounded-2xl shadow-xl hover:bg-orange-50 transition active:scale-95 flex items-center gap-2">
            <span>🖨️</span> Print Badge
        </button>
        <button onclick="window.close()" class="bg-slate-900 text-white font-bold px-8 py-3 rounded-2xl shadow-xl hover:bg-slate-800 transition active:scale-95">
            Close
        </button>
    </div>

</body>
</html>