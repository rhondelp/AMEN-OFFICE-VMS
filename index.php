<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/sidebar.php';
render_head('Home');
?>

<nav class="flex justify-between items-center px-6 lg:px-16 py-4 bg-white/80 backdrop-blur-xl border-b border-surface-200/60 sticky top-0 z-50">
    <div class="flex items-center gap-3">
        <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Tangub City Logo" class="h-10 w-auto">
        <h1 class="text-xl font-bold text-surface-900 tracking-tight">Amen's Office <span class="text-brand-600">VMS</span></h1>
    </div>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium">
        <a href="#features" class="text-surface-800/60 hover:text-brand-600 transition-colors">Features</a>
        <button onclick="gateKeeper('dashboard.php')" class="text-surface-800/60 hover:text-brand-600 transition-colors">View Logs</button>
        <button onclick="gateKeeper('register.php')" class="bg-brand-600 text-white px-5 py-2.5 rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-600/20 transition-all active:scale-[0.98]">Get Started</button>
    </div>
    <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="md:hidden p-2 text-surface-800/60">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
</nav>

<div id="mobileMenu" class="hidden md:hidden fixed inset-0 bg-surface-900/80 backdrop-blur-sm z-50">
    <div class="bg-white w-72 h-full shadow-2xl p-6 flex flex-col">
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-bold text-surface-900">Menu</h2>
            <button onclick="this.closest('#mobileMenu').classList.add('hidden')" class="p-1 text-surface-800/40 hover:text-surface-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="space-y-1 flex-1">
            <a href="#features" onclick="this.closest('#mobileMenu').classList.add('hidden')" class="block py-3 px-4 rounded-xl text-surface-800/70 hover:bg-surface-50 text-sm font-medium">Features</a>
            <button onclick="gateKeeper('dashboard.php')" class="w-full text-left py-3 px-4 rounded-xl text-surface-800/70 hover:bg-surface-50 text-sm font-medium">View Logs</button>
            <button onclick="gateKeeper('register.php')" class="w-full text-left py-3 px-4 rounded-xl bg-brand-600 text-white text-sm font-medium mt-2">Get Started</button>
        </nav>
    </div>
</div>

<header class="relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500">
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-400 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-700 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
    </div>
    <div class="container mx-auto px-6 lg:px-16 py-20 lg:py-28 relative z-10 flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
        <div class="lg:w-1/2" data-aos="fade-right" data-aos-delay="100">
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white/90 text-xs font-semibold px-4 py-2 rounded-full mb-8 border border-white/20">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                Trusted by Tangub City Office
            </div>
            <h2 class="text-4xl lg:text-6xl font-extrabold text-white leading-[1.05] tracking-tight mb-6" style="text-wrap:balance;">
                Manage office visitors <span class="text-white/60">with clarity.</span>
            </h2>
            <p class="text-lg text-white/75 leading-relaxed mb-10 max-w-lg" style="text-wrap:pretty;">
                Track every entry and exit in real time. Secure, efficient, and built for the way your office actually works.
            </p>
            <div class="flex flex-wrap gap-4">
                <button onclick="gateKeeper('register.php')" class="bg-white text-brand-700 px-8 py-4 rounded-2xl font-semibold shadow-2xl shadow-black/10 hover:bg-surface-50 transition-all hover:-translate-y-0.5 active:scale-[0.98] flex items-center gap-2">
                    Check-in Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
                <button onclick="gateKeeper('dashboard.php')" class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-white/10 transition-all hover:-translate-y-0.5 active:scale-[0.98]">
                    Admin Dashboard
                </button>
            </div>
        </div>
        <div class="lg:w-1/2" data-aos="zoom-in" data-aos-delay="300">
            <div class="relative">
                <div class="absolute -inset-4 bg-white/10 rounded-[3rem] blur-2xl"></div>
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80"
                     alt="Modern office interior with visitors at reception"
                     class="relative w-full rounded-[2rem] shadow-2xl border border-white/20 object-cover h-[340px] lg:h-[420px]">
            </div>
        </div>
    </div>
</header>

<section id="features" class="py-24 lg:py-32">
    <div class="container mx-auto px-6 lg:px-16">
        <div class="max-w-2xl mb-16" data-aos="fade-up">
            <p class="text-brand-600 font-semibold text-sm tracking-wide uppercase mb-3">What we offer</p>
            <h3 class="text-3xl lg:text-5xl font-extrabold text-surface-900 tracking-tight leading-tight" style="text-wrap:balance;">Built for real office security needs</h3>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white p-8 lg:p-10 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 hover:shadow-lg hover:shadow-brand-500/5 group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-brand-50 w-12 h-12 flex items-center justify-center rounded-xl mb-5 text-brand-600 group-hover:bg-brand-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-surface-900 mb-2">Quick registration</h4>
                <p class="text-surface-800/55 leading-relaxed text-sm">Fast visitor entry with name, purpose, host details, and automated PH timestamps — no paper forms.</p>
            </div>

            <div class="bg-white p-8 lg:p-10 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 hover:shadow-lg hover:shadow-brand-500/5 group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-amber-50 w-12 h-12 flex items-center justify-center rounded-xl mb-5 text-amber-600 group-hover:bg-amber-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-surface-900 mb-2">Real-time check-in/out</h4>
                <p class="text-surface-800/55 leading-relaxed text-sm">Know exactly who is inside the building right now. Status updates the moment a visitor arrives or leaves.</p>
            </div>

            <div class="bg-white p-8 lg:p-10 rounded-3xl border border-surface-200/60 hover:border-brand-200 transition-all duration-300 hover:shadow-lg hover:shadow-brand-500/5 group lg:col-span-2" data-aos="fade-up" data-aos-delay="300">
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="bg-red-50 w-12 h-12 flex items-center justify-center rounded-xl text-red-500 group-hover:bg-red-100 transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-surface-900 mb-2">Security blocklist</h4>
                        <p class="text-surface-800/55 leading-relaxed text-sm max-w-xl">Instantly block unwanted visitors by name or contact number. Flagged individuals are denied entry at registration — keeping your office safe without manual screening.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="passwordModal" class="fixed inset-0 bg-surface-900/70 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl" onclick="event.stopPropagation()">
        <div class="text-center mb-8">
            <div class="bg-brand-50 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-surface-900 tracking-tight">Admin access</h3>
            <p class="text-surface-800/45 text-sm mt-1">Enter the system password to continue</p>
        </div>
        <input type="password" id="sysPass"
               class="w-full border-2 border-surface-200 bg-surface-50 p-4 rounded-2xl focus:border-brand-500 focus:bg-white outline-none transition-all text-center text-lg tracking-[0.3em] font-medium"
               placeholder="••••••••">
        <div id="passError" class="text-red-500 text-xs text-center mt-3 mb-2 hidden font-semibold">Incorrect password. Try again.</div>
        <button onclick="validatePass()" class="w-full bg-brand-600 text-white py-3.5 rounded-2xl font-semibold hover:bg-brand-700 transition-all mt-4 active:scale-[0.98] shadow-lg shadow-brand-600/20">Confirm identity</button>
        <button onclick="closeModal()" class="w-full mt-2 text-surface-800/35 text-sm hover:text-surface-800/60 py-2 transition-colors">Cancel</button>
    </div>
</div>

<footer class="bg-surface-900 text-white py-12 pb-24 lg:pb-12">
    <div class="container mx-auto px-6 lg:px-16 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-7 w-auto opacity-50">
            <p class="text-sm text-white/35">© 2026 Amen's Office Visitor MS</p>
        </div>
        <p class="text-xs text-white/25">Amen's Office — Tangub City</p>
    </div>
</footer>

<?php require_once __DIR__ . '/includes/mobile_nav.php'; ?>
<script>
    AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });
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
        if (document.getElementById('sysPass').value === 'asensoamen') {
            window.location.href = targetUrl;
            return;
        }
        document.getElementById('passError').classList.remove('hidden');
        const card = document.querySelector('#passwordModal > div');
        card.style.animation = 'none';
        card.offsetHeight;
        card.style.animation = 'shake 0.4s ease';
    }

    document.getElementById('passwordModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('sysPass').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') validatePass();
        if (e.key === 'Escape') closeModal();
    });
</script>
<style>@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-8px)}40%{transform:translateX(8px)}60%{transform:translateX(-4px)}80%{transform:translateX(4px)}}</style>
</body>
</html>
