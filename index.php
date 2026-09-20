<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amen's Office Visitor MS</title>
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
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                        },
                        surface: {
                            50: '#fafaf9',
                            100: '#f5f5f4',
                            200: '#e7e5e4',
                            800: '#1c1917',
                            900: '#0c0a09',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .grain {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }
        .hero-gradient {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 40%, #fb923c 100%);
        }
        .hero-mesh {
            background:
                radial-gradient(ellipse at 20% 50%, rgba(251, 146, 60, 0.4) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(234, 88, 12, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(249, 115, 22, 0.2) 0%, transparent 50%);
        }
        .card-glow:hover {
            box-shadow: 0 20px 60px -12px rgba(249, 115, 22, 0.15);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafaf9 100%);
        }
        .scroll-hidden { opacity: 0; transform: translateY(20px); }
        .scroll-visible { opacity: 1; transform: translateY(0); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</head>
<body class="bg-surface-50 text-surface-800 overflow-x-hidden">
    <div class="grain"></div>

    <nav class="flex justify-between items-center px-8 lg:px-16 py-5 bg-white/80 backdrop-blur-xl border-b border-surface-200/60 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Tangub City Logo" class="h-11 w-auto">
            <div>
                <h1 class="text-xl font-bold text-surface-900 tracking-tight">Amen's Office <span class="text-brand-600">VMS</span></h1>
            </div>
        </div>
        <div class="hidden md:flex items-center gap-8 font-medium text-sm">
            <a href="#features" class="text-surface-800/70 hover:text-brand-600 transition-colors duration-200">Features</a>
            <button onclick="gateKeeper('dashboard.php')" class="text-surface-800/70 hover:text-brand-600 transition-colors duration-200">View Logs</button>
            <button onclick="gateKeeper('register.php')" class="bg-brand-600 text-white px-6 py-2.5 rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-600/20 transition-all duration-200 hover:shadow-brand-600/30 active:scale-[0.98]">Get Started</button>
        </div>
    </nav>

    <header class="hero-gradient relative overflow-hidden">
        <div class="hero-mesh absolute inset-0"></div>
        <div class="container mx-auto px-8 lg:px-16 py-20 lg:py-28 relative z-10 flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <div class="lg:w-1/2" data-aos="fade-right" data-aos-delay="100">
                <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white/90 text-xs font-semibold px-4 py-2 rounded-full mb-8 border border-white/20">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Trusted by Tangub City Office
                </div>
                <h2 class="text-5xl lg:text-6xl font-extrabold text-white leading-[1.05] tracking-tight mb-6" style="text-wrap: balance;">
                    Manage office visitors <span class="text-white/70">with clarity.</span>
                </h2>
                <p class="text-lg text-white/80 leading-relaxed mb-10 max-w-lg" style="text-wrap: pretty;">
                    Track every entry and exit in real time. Secure, efficient, and built for the way your office actually works.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="gateKeeper('register.php')" class="bg-white text-brand-700 px-8 py-4 rounded-2xl font-semibold shadow-2xl shadow-black/10 hover:bg-surface-50 transition-all duration-200 hover:-translate-y-0.5 active:scale-[0.98] flex items-center gap-2">
                        Check-in Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <button onclick="gateKeeper('dashboard.php')" class="border-2 border-white/40 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-white/10 transition-all duration-200 hover:-translate-y-0.5 active:scale-[0.98]">
                        Admin Dashboard
                    </button>
                </div>
            </div>
            <div class="lg:w-1/2" data-aos="zoom-in" data-aos-delay="300">
                <div class="relative">
                    <div class="absolute -inset-4 bg-white/10 rounded-[3rem] blur-2xl"></div>
                    <img src="https://i.ytimg.com/vi/n6hTh9QvM8E/maxresdefault.jpg"
                         alt="Office lobby with visitors"
                         class="relative w-full rounded-[2rem] shadow-2xl border border-white/20 object-cover h-[380px] lg:h-[440px]">
                </div>
            </div>
        </div>
    </header>

    <section id="features" class="py-24 lg:py-32">
        <div class="container mx-auto px-8 lg:px-16">
            <div class="max-w-2xl mb-16 lg:mb-20" data-aos="fade-up">
                <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-3">What we offer</p>
                <h3 class="text-4xl lg:text-5xl font-extrabold text-surface-900 tracking-tight leading-tight" style="text-wrap: balance;">Built for real office security needs</h3>
            </div>

            <div class="grid lg:grid-cols-2 gap-6 lg:gap-8">
                <div class="stat-card p-10 lg:p-12 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 card-glow group" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-brand-50 w-14 h-14 flex items-center justify-center rounded-2xl mb-6 text-brand-600 group-hover:bg-brand-100 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-surface-900 mb-2">Quick registration</h4>
                    <p class="text-surface-800/60 leading-relaxed">Fast visitor entry with name, purpose, host details, and automated PH timestamps — no paper forms.</p>
                </div>

                <div class="stat-card p-10 lg:p-12 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 card-glow group" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-amber-50 w-14 h-14 flex items-center justify-center rounded-2xl mb-6 text-amber-600 group-hover:bg-amber-100 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-surface-900 mb-2">Real-time check-in/out</h4>
                    <p class="text-surface-800/60 leading-relaxed">Know exactly who is inside the building right now. Status updates the moment a visitor arrives or leaves.</p>
                </div>

                <div class="stat-card p-10 lg:p-12 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 card-glow group lg:col-span-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="bg-red-50 w-14 h-14 flex items-center justify-center rounded-2xl mb-2 text-red-500 group-hover:bg-red-100 transition-colors shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-surface-900 mb-2">Security blocklist</h4>
                            <p class="text-surface-800/60 leading-relaxed max-w-xl">Instantly block unwanted visitors by name or contact number. Flagged individuals are denied entry at registration — keeping your office safe without manual screening.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="passwordModal" class="fixed inset-0 bg-surface-900/70 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl shadow-surface-900/20 transform transition-all" onclick="event.stopPropagation()">
            <div class="text-center mb-8">
                <div class="bg-brand-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-surface-900 tracking-tight">Admin access</h3>
                <p class="text-surface-800/50 text-sm mt-1">Enter the system password to continue</p>
            </div>
            <input type="password" id="sysPass"
                   class="w-full border-2 border-surface-200 bg-surface-50 p-4 rounded-2xl focus:border-brand-500 focus:bg-white outline-none transition-all duration-200 text-center text-lg tracking-[0.3em] font-medium"
                   placeholder="••••••••">
            <div id="passError" class="text-red-500 text-xs text-center mt-3 mb-2 hidden font-semibold">Incorrect password. Try again.</div>
            <button onclick="validatePass()" class="w-full bg-brand-600 text-white py-4 rounded-2xl font-semibold hover:bg-brand-700 transition-all duration-200 mt-4 active:scale-[0.98] shadow-lg shadow-brand-600/20">Confirm identity</button>
            <button onclick="closeModal()" class="w-full mt-2 text-surface-800/40 text-sm hover:text-surface-800/60 py-2 transition-colors">Cancel</button>
        </div>
    </div>

    <footer class="bg-surface-900 text-white py-14">
        <div class="container mx-auto px-8 lg:px-16 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-8 w-auto opacity-60">
                <p class="text-sm text-white/40">© 2026 Amen's Office Visitor MS</p>
            </div>
            <p class="text-xs text-white/30">Amen's Office — Tangub City</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, easing: 'ease-out-cubic' });
        let targetUrl = '';
        function gateKeeper(url) {
            targetUrl = url;
            const modal = document.getElementById('passwordModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => document.getElementById('sysPass').focus(), 100);
        }
        function closeModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('sysPass').value = '';
            document.getElementById('passError').classList.add('hidden');
        }
        function validatePass() {
            const pass = document.getElementById('sysPass').value;
            if (pass === "asensoamen") {
                window.location.href = targetUrl;
            } else {
                const error = document.getElementById('passError');
                error.classList.remove('hidden');
                const card = document.querySelector('#passwordModal > div');
                card.style.animation = 'none';
                card.offsetHeight;
                card.style.animation = 'shake 0.4s ease';
            }
        }
        document.getElementById('passwordModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.getElementById('sysPass').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') validatePass();
            if (e.key === 'Escape') closeModal();
        });
    </script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }
    </style>
</body>
</html>
