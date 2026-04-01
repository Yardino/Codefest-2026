<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$rawRole = strtolower((string) ($user['role'] ?? 'guest'));
$roleAliases = [
    'user' => 'operator',
    'admin' => 'beheerder',
    'administrator' => 'beheerder',
];
$role = $roleAliases[$rawRole] ?? $rawRole;

$roleLabels = [
    'guest' => 'Gast',
    'operator' => 'Operator',
    'reviewer' => 'Reviewer',
    'beheerder' => 'Beheerder',
];

$navItems = [
    'guest' => [
        ['label' => 'Inloggen', 'link' => 'login'],
    ],
    'operator' => [
        ['label' => 'Dashboard', 'link' => 'dashboard'],
        ['label' => 'Kandidaten', 'link' => 'candidates'],
        ['label' => 'Divisies', 'link' => 'divisions'],
        ['label' => 'Screening', 'link' => 'screening'],
        ['label' => 'Toewijzingen', 'link' => 'placements'],
        ['label' => 'Automatische run', 'link' => 'run'],
        ['label' => 'Rapportages', 'link' => 'reports'],
        ['label' => 'Help', 'link' => 'help'],
    ],
    'reviewer' => [
        ['label' => 'Dashboard', 'link' => 'dashboard'],
        ['label' => 'Kandidaten', 'link' => 'candidates'],
        ['label' => 'Divisies', 'link' => 'divisions'],
        ['label' => 'Screening', 'link' => 'screening'],
        ['label' => 'Toewijzingen', 'link' => 'placements'],
        ['label' => 'Automatische run', 'link' => 'run'],
        ['label' => 'Rapportages', 'link' => 'reports'],
        ['label' => 'Auditlog', 'link' => 'auditlog'],
        ['label' => 'Help', 'link' => 'help'],
    ],
    'beheerder' => [
        ['label' => 'Dashboard', 'link' => 'dashboard'],
        ['label' => 'Kandidaten', 'link' => 'candidates'],
        ['label' => 'Divisies', 'link' => 'divisions'],
        ['label' => 'Screening', 'link' => 'screening'],
        ['label' => 'Toewijzingen', 'link' => 'placements'],
        ['label' => 'Automatische run', 'link' => 'run'],
        ['label' => 'Rapportages', 'link' => 'reports'],
        ['label' => 'Auditlog', 'link' => 'auditlog'],
        ['label' => 'Help', 'link' => 'help'],
    ],
];

$items = $navItems[$role] ?? $navItems['guest'];

$userMenuItems = [];
if ($user) {
    $userMenuItems = [
        ['label' => 'Account', 'link' => 'account'],
        ['label' => 'Beveiliging', 'link' => 'security'],
    ];

    if ($role === 'beheerder') {
        $userMenuItems[] = ['label' => 'Gebruikersbeheer', 'link' => 'users'];
    }

    $userMenuItems[] = ['label' => 'Uitloggen', 'link' => 'logout.php'];
}

function navIcon(string $label): string
{
    $icons = [
        'Dashboard' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3zm10 8h8v-6h-8zm0-10h8V3h-8zM3 21h8v-6H3z" stroke-linejoin="round"/></svg>',
        'Kandidaten' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke-linecap="round"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke-linecap="round"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke-linecap="round"/></svg>',
        'Divisies' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M9 20V10m6 10V10"/></svg>',
        'Screening' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
        'Toewijzingen' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01" stroke-linecap="round"/></svg>',
        'Automatische run' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2l-2 7h5l-5 13 2-8H8z" stroke-linejoin="round"/></svg>',
        'Rapportages' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 14l3-3 3 2 4-5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'Auditlog' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h5" stroke-linecap="round"/></svg>',
        'Help' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 1 1 5.8 1c0 2-3 3-3 3"/><path d="M12 17h.01" stroke-linecap="round"/></svg>',
        'Inloggen' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3" stroke-linecap="round"/></svg>',
        'Account activeren' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m7 10 3 3 7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'Account' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 1 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>',
        'Beveiliging' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7z"/><path d="M9.5 12.5 11 14l3.5-3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'Gebruikersbeheer' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke-linecap="round"/></svg>',
        'Uitloggen' => '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9" stroke-linecap="round"/></svg>',
    ];

    return $icons[$label] ?? '<svg class="size-[1.05em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>';
}

function pageLinks(array $items): array
{
    $pages = [];

    foreach ($items as $item) {
        if (!isset($item['link'])) {
            continue;
        }

        if (!preg_match('/\.php$/', $item['link'])) {
            $pages[] = $item['link'];
        }
    }

    return $pages;
}

$currentPage = $_GET['page'] ?? 'dashboard';
$allowedPages = array_unique(array_merge(pageLinks($items), pageLinks($userMenuItems), ['404', 'login', 'register']));

if (isset($_GET['page']) && !in_array($_GET['page'], $allowedPages, true)) {
    header('Location: index.php?page=404');
    exit;
}
?>

<style>
  :root {
    --app-frame-margin: 1rem;
    --app-shell-gap-x: 1rem;
    --app-shell-gap-y: 0.6rem;
    --app-sidebar-width-mobile: 5.5rem;
    --app-sidebar-width-desktop: 9.75rem;
    --app-topbar-height: 3.5rem;
    --app-menu-item-height: 2rem;
    --app-menu-item-font-size: 0.68rem;
    --app-sidebar-height: calc(100vh - (2 * var(--app-frame-margin)) - var(--app-shell-gap-y) - var(--app-topbar-height));
  }

  html {
    scrollbar-gutter: stable;
  }

  .app-layout {
    width: calc(100% - 2rem);
    min-height: calc(100vh - 2rem);
    margin: var(--app-frame-margin) auto;
    display: grid;
    column-gap: var(--app-shell-gap-x);
    row-gap: var(--app-shell-gap-y);
    grid-template-columns: var(--app-sidebar-width-mobile) minmax(0, 1fr);
    grid-template-areas:
      "top top"
      "side body";
    align-items: start;
  }

  .app-layout--guest {
    grid-template-columns: minmax(0, 1fr);
    grid-template-areas:
      "top"
      "body";
  }

  .app-topbar {
    grid-area: top;
    height: var(--app-topbar-height);
    min-height: var(--app-topbar-height);
    max-height: var(--app-topbar-height);
    border: 1px solid color-mix(in oklab, var(--color-base-content) 18%, transparent);
    border-radius: var(--radius-box);
    background: var(--color-base-100);
    box-shadow: 0 12px 30px color-mix(in oklab, var(--color-base-content) 10%, transparent);
  }

  .app-topbar .navbar {
    height: 100%;
    min-height: 100%;
  }

  .app-sidebar {
    grid-area: side;
    align-self: start;
    inline-size: 100%;
    min-inline-size: 100%;
    max-inline-size: 100%;
    height: var(--app-sidebar-height);
    min-height: var(--app-sidebar-height);
    max-height: var(--app-sidebar-height);
    overflow-y: auto;
    border: 1px solid color-mix(in oklab, var(--color-base-content) 18%, transparent);
    border-radius: var(--radius-box);
    background: var(--color-base-100);
    box-shadow: 0 12px 30px color-mix(in oklab, var(--color-base-content) 8%, transparent);
  }

  .app-layout__body {
    grid-area: body;
    display: flex;
    flex-direction: column;
    height: var(--app-sidebar-height);
    min-height: var(--app-sidebar-height);
    max-height: var(--app-sidebar-height);
    min-width: 0;
  }

  .app-workspace {
    flex: 1;
    height: 100%;
    min-height: 100%;
    max-height: 100%;
    overflow: auto;
    border: 1px solid color-mix(in oklab, var(--color-base-content) 18%, transparent);
    border-radius: var(--radius-box);
    background: var(--color-base-100);
    box-shadow: 0 12px 30px color-mix(in oklab, var(--color-base-content) 8%, transparent);
    padding: 0.75rem;
  }

  .app-main {
    display: flex;
    justify-content: center;
    width: 100%;
    min-height: 100%;
  }

  .app-main > * {
    width: min(100%, 72rem);
    margin-inline: auto;
  }

  .app-sidebar__list {
    display: grid;
    gap: 0.4rem;
  }

  .app-sidebar__link {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    min-height: var(--app-menu-item-height);
    height: var(--app-menu-item-height);
    padding: 0.45rem 0.55rem;
    border: 1px solid color-mix(in oklab, var(--color-base-content) 18%, transparent);
    border-radius: calc(var(--radius-box) - 0.15rem);
    color: var(--color-base-content);
    transition: background-color 120ms ease, border-color 120ms ease;
  }

  .app-sidebar__link:hover {
    background: color-mix(in oklab, var(--color-base-content) 4%, var(--color-base-100));
  }

  .app-sidebar__link--active {
    background: var(--color-base-content);
    border-color: var(--color-base-content);
    color: var(--color-base-100);
  }

  .app-sidebar__link--active svg {
    color: inherit;
  }

  .app-sidebar__icon {
    display: none;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 1.2rem;
    height: 1.2rem;
  }

  .app-sidebar__label {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: var(--app-menu-item-font-size);
    line-height: 1.1;
    white-space: nowrap;
  }

  @media (min-width: 1024px) {
    .app-layout--with-sidebar {
      grid-template-columns: var(--app-sidebar-width-desktop) minmax(0, 1fr);
    }
  }

  @media (max-width: 1023px) {
    .app-sidebar__link {
      padding-inline: 0.5rem;
    }
  }

  @media (max-width: 767px) {
    .app-layout {
      width: calc(100% - 1rem);
      min-height: calc(100vh - 1rem);
      margin: 0.5rem auto;
      row-gap: 0.5rem;
      grid-template-columns: 1fr;
      grid-template-areas:
        "top"
        "side"
        "body";
    }

    .app-layout--guest {
      grid-template-areas:
        "top"
        "body";
    }

    .app-sidebar {
      height: auto;
      min-height: auto;
      max-height: none;
      overflow: visible;
    }

    .app-layout__body {
      height: auto;
      min-height: auto;
      max-height: none;
    }

    .app-sidebar__menu-text {
      display: block;
    }

    .app-sidebar__list {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .app-workspace {
      height: auto;
      min-height: auto;
      max-height: none;
      overflow: visible;
    }
  }
</style>

<header class="app-topbar">
  <div class="navbar px-3 py-2 md:px-4">
    <div class="navbar-start">
      <a
        href="index.php?page=<?= $user ? 'dashboard' : 'login' ?>"
        class="btn btn-ghost h-auto px-2 normal-case"
        onclick="navigateTo('<?= $user ? 'dashboard' : 'login' ?>'); return false;"
      >
        <div class="text-left leading-tight">
          <div class="text-sm font-semibold text-base-content md:text-[0.95rem]">Recruitment Allocation Hub</div>
        </div>
      </a>
    </div>

    <div class="navbar-end">
      <?php if ($user): ?>
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-outline btn-sm h-8 min-h-0 rounded-full px-3">
            <span class="text-xs sm:text-sm"><?= htmlspecialchars((string) ($user['name'] ?? 'Gebruiker'), ENT_QUOTES, 'UTF-8') ?> - Ingelogd</span>
          </div>

          <ul tabindex="0" class="menu dropdown-content z-[1] mt-3 w-64 rounded-box border border-base-300 bg-base-100 p-2 shadow-xl">
            <?php foreach ($userMenuItems as $item): ?>
              <li>
                <a
                  href="<?= str_contains($item['link'], '.php') ? htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') : 'index.php?page=' . htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') ?>"
                  class="<?= $currentPage === $item['link'] ? 'active' : '' ?>"
                  onclick="navigateTo('<?= htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') ?>'); return false;"
                >
                  <?= navIcon($item['label']) ?>
                  <span><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php elseif ($currentPage !== 'login'): ?>
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-outline btn-sm h-8 min-h-0 rounded-full px-3">
            <span class="text-xs sm:text-sm">Gast</span>
          </div>
          <ul tabindex="0" class="menu dropdown-content z-[1] mt-3 w-56 rounded-box border border-base-300 bg-base-100 p-2 shadow-xl">
            <li>
              <a href="index.php?page=login" onclick="navigateTo('login'); return false;">
                <?= navIcon('Inloggen') ?>
                <span>Inloggen</span>
              </a>
            </li>
            <li>
              <a href="index.php?page=activate" onclick="navigateTo('activate'); return false;">
                <?= navIcon('Account activeren') ?>
                <span>Account activeren</span>
              </a>
            </li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>

<?php if ($user): ?>
  <aside class="app-sidebar p-2 md:p-3">
    <div class="app-sidebar__menu-text px-2 pb-3 pt-1 text-xs font-semibold uppercase tracking-[0.22em] text-base-content/60">Menu</div>
    <nav aria-label="Hoofdnavigatie">
      <ul class="app-sidebar__list">
        <?php foreach ($items as $item): ?>
          <?php $isActive = $currentPage === $item['link']; ?>
          <li>
            <a
              href="index.php?page=<?= htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') ?>"
              class="app-sidebar__link <?= $isActive ? 'app-sidebar__link--active' : '' ?>"
              title="<?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>"
              onclick="navigateTo('<?= htmlspecialchars($item['link'], ENT_QUOTES, 'UTF-8') ?>'); return false;"
            >
              <span class="app-sidebar__icon"><?= navIcon($item['label']) ?></span>
              <span class="app-sidebar__label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </aside>
<?php endif; ?>

<script>
function navigateTo(page) {
  const url = page.includes('.php') ? page : `index.php?page=${page}`;
  const currentUrl = window.location.origin + window.location.pathname + window.location.search;
  const fullUrl = url.startsWith('http') ? url : window.location.origin + '/' + url;

  if (fullUrl === currentUrl) {
    return;
  }

  if (url.includes('logout.php')) {
    fetch('server/api/logout.php', {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        window.location.href = data.redirect || 'index.php?page=login';
      }
    })
    .catch(() => {
      window.location.href = fullUrl;
    });
    return;
  }

  history.pushState({ page: page }, '', url);

  fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.text();
  })
  .then(html => {
    const mainContent = document.getElementById('main-content');
    if (mainContent) {
      mainContent.innerHTML = html;
    }
  })
  .catch(() => {
    window.location.href = fullUrl;
  });
}

window.addEventListener('popstate', function(event) {
  if (event.state && event.state.page) {
    navigateTo(event.state.page);
  }
});
</script>
