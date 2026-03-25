<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amen's Office Visitor MS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .orange-gradient { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }
    </style>
</head>
<body class="bg-orange-50 text-gray-800 overflow-x-hidden">

    <nav class="flex justify-between items-center px-10 py-4 bg-white shadow-md sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-12 w-auto">
            <h1 class="text-2xl font-bold text-orange-600">Amen's Office <span class="text-slate-900">VMS</span></h1>
        </div>
        <div class="hidden md:flex space-x-8 font-medium">
            <a href="#features" class="hover:text-orange-600 transition">Features</a>
            <button onclick="gateKeeper('dashboard.php')" class="hover:text-orange-600 transition font-medium">View Logs</button>
            <button onclick="gateKeeper('register.php')" class="bg-orange-600 text-white px-6 py-2 rounded-xl hover:bg-orange-700 shadow-lg shadow-orange-200 transition">Get Started</button>
        </div>
    </nav>

    <header class="orange-gradient text-white">
        <div class="container mx-auto px-6 py-24 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2" data-aos="fade-right">
                <h2 class="text-6xl font-extrabold leading-tight mb-6">Manage Office Visitors <span class="text-orange-200">Seamlessly.</span></h2>
                <p class="text-lg text-orange-50 mb-8 opacity-90">Secure, automated, and efficient. Track every entry and exit at Amen's Office with real-time analytics and security blocking.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="gateKeeper('register.php')" class="bg-white text-orange-600 px-10 py-4 rounded-full font-bold shadow-2xl hover:bg-orange-50 transition transform hover:-translate-y-1">Check-in Now</button>
                    <button onclick="gateKeeper('dashboard.php')" class="border-2 border-white text-white px-10 py-4 rounded-full font-bold hover:bg-white hover:text-orange-600 transition transform hover:-translate-y-1">Admin Dashboard</button>
                </div>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0" data-aos="zoom-in">
                <div class="relative p-2 bg-white/20 rounded-[3rem] backdrop-blur-sm">
                    <img src="https://i.ytimg.com/vi/n6hTh9QvM8E/maxresdefault.jpg" 
                         alt="Office Hero" 
                         class="w-full rounded-[2.5rem] shadow-2xl border-4 border-white/30 object-cover h-[400px]">
                </div>
            </div>
        </div>
    </header>

    <section id="features" class="py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <h3 class="text-4xl font-extrabold text-slate-900">System Features</h3>
                <div class="w-24 h-2 bg-orange-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition border-b-8 border-orange-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-orange-100 w-16 h-16 flex items-center justify-center rounded-2xl mb-6 text-3xl">📝</div>
                    <h4 class="text-xl font-bold mb-3">Quick Registration</h4>
                    <p class="text-gray-500 leading-relaxed">Fast entry for visitors including purpose, host details, and automated PH timestamps.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition border-b-8 border-blue-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-2xl mb-6 text-3xl">🕒</div>
                    <h4 class="text-xl font-bold mb-3">Check-in/Out</h4>
                    <p class="text-gray-500 leading-relaxed">Real-time status tracking. Know exactly who is currently inside the building.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl shadow-xl hover:shadow-2xl transition border-b-8 border-red-500" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-red-100 w-16 h-16 flex items-center justify-center rounded-2xl mb-6 text-3xl">🚫</div>
                    <h4 class="text-xl font-bold mb-3">Security Blocklist</h4>
                    <p class="text-gray-500 leading-relaxed">Instantly block unwanted visitors by name or number to maintain office safety.</p>
                </div>
            </div>
        </div>
    </section>

    <div id="passwordModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl transform transition-all">
            <div class="text-center mb-6">
                <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">🔑</div>
                <h3 class="text-2xl font-bold text-slate-800">Admin Access</h3>
                <p class="text-gray-500 text-sm">Please enter the system password</p>
            </div>
            <input type="password" id="sysPass" class="w-full border-2 border-gray-100 bg-gray-50 p-4 rounded-2xl focus:border-orange-500 outline-none mb-4 text-center tracking-widest" placeholder="••••••••">
            <div id="passError" class="text-red-500 text-xs text-center mb-4 hidden font-bold">Incorrect Password! Try again.</div>
            <button onclick="validatePass()" class="w-full bg-orange-600 text-white py-4 rounded-2xl font-bold hover:bg-orange-700 transition">Confirm Identity</button>
            <button onclick="closeModal()" class="w-full mt-2 text-gray-400 text-sm hover:text-gray-600 py-2">Cancel</button>
        </div>
    </div>

    <footer class="bg-slate-900 text-white py-12 text-center">
        <p class="opacity-60">© 2026 Amen's Office Visitor MS. All Rights Reserved.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
        let targetUrl = '';
        function gateKeeper(url) {
            targetUrl = url;
            document.getElementById('passwordModal').classList.remove('hidden');
            document.getElementById('sysPass').focus();
        }
        function closeModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('sysPass').value = '';
            document.getElementById('passError').classList.add('hidden');
        }
        function validatePass() {
            const pass = document.getElementById('sysPass').value;
            if(pass === "asensoamen") {
                window.location.href = targetUrl;
            } else {
                const error = document.getElementById('passError');
                error.classList.remove('hidden');
                const modal = document.querySelector('#passwordModal > div');
                modal.classList.add('translate-x-2');
                setTimeout(() => modal.classList.remove('translate-x-2'), 100);
            }
        }
        document.getElementById('sysPass').addEventListener("keyup", function(event) {
            if (event.key === "Enter") { validatePass(); }
        });
    </script>
</body>
</html> 