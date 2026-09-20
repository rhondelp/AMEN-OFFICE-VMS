<?php
function render_mobile_nav(string $active = ''): void {
    $items = [
        ['url' => 'index.php',     'label' => 'Home',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
        ['url' => 'dashboard.php', 'label' => 'Dashboard','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
        ['url' => 'register.php',  'label' => 'Register', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>'],
        ['url' => 'security.php',  'label' => 'Blocklist', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>'],
    ];
?>
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-xl border-t border-surface-200/60 z-50 px-2 py-2 safe-bottom">
        <div class="flex justify-around">
            <?php foreach ($items as $item): ?>
                <a href="<?= $item['url'] ?>"
                   class="flex flex-col items-center gap-0.5 py-1.5 px-3 rounded-xl text-[10px] font-medium transition-colors <?= $active === $item['url'] ? 'text-brand-600' : 'text-surface-800/40' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><?= $item['icon'] ?></svg>
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
    <style>.safe-bottom { padding-bottom: max(0.5rem, env(safe-area-inset-bottom)); }</style>
<?php
}
