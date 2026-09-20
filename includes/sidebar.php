<?php
function render_sidebar(string $active = ''): void {
    $links = [
        ['section' => 'Main', 'items' => [
            ['url' => 'index.php',      'icon' => 'home',  'label' => 'Home'],
            ['url' => 'dashboard.php',  'icon' => 'chart', 'label' => 'Dashboard'],
            ['url' => 'register.php',   'icon' => 'user-plus', 'label' => 'New registration'],
        ]],
        ['section' => 'Security', 'items' => [
            ['url' => 'security.php',   'icon' => 'shield-off', 'label' => 'Blocklist'],
        ]],
    ];

    $icons = [
        'home'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        'chart'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        'user-plus'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
        'shield-off' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>',
    ];
?>
    <aside class="w-72 bg-surface-900 text-white p-6 sticky top-0 h-screen flex flex-col shrink-0 max-lg:hidden">
        <div class="flex items-center gap-3 mb-10">
            <img src="https://www.tangubcity.gov.ph/application/files/cache/thumbnails/eeeec44ce1ca7ad2e753b99813495fff.png" alt="Logo" class="h-9 w-auto opacity-80">
            <div>
                <h1 class="text-lg font-bold tracking-tight">Amen's Office</h1>
                <p class="text-[10px] text-white/30 font-medium uppercase tracking-widest">Visitor Management</p>
            </div>
        </div>

        <nav class="space-y-1 flex-1">
            <?php foreach ($links as $group): ?>
                <p class="text-[10px] font-semibold text-white/25 uppercase tracking-[0.15em] mb-3 mt-6 first:mt-0 px-4"><?= $group['section'] ?></p>
                <?php foreach ($group['items'] as $link): ?>
                    <a href="<?= $link['url'] ?>"
                       class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl text-sm font-medium <?= $active === $link['url'] ? 'active' : 'text-white/60' ?>">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $icons[$link['icon']] ?></svg>
                        <?= $link['label'] ?>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
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
<?php
}
