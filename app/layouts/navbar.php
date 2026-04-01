<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;

$navItems = [
    'guest' => [
        ['label'=>'Home', 'link'=>'home'],
        ['label'=>'Login', 'link'=>'login'],
        ['label'=>'Register', 'link'=>'register'],
        ['label'=> 'More', 'children' => [
                ['label'=> 'Table', 'link'=>'table'],
                ['label'=> 'Multiform', 'link'=>'multiform']
            ]
        ],
        ['label'=>'Crud', 'link'=>'crud']
    ],
    'user' => [
        ['label'=>'Home', 'link'=>'home'],
        ['label'=>'Products', 'link'=>'products'],
        ['label'=>'Cart', 'link'=>'cart'],
        ['label'=>'Logout', 'link'=>'logout.php']
    ],
    'admin' => [
        ['label'=>'Admin Panel', 'link'=>'admin'],
        ['label'=>'Logout', 'link'=>'logout.php']
    ]
];

$role = $user['role'] ?? 'guest';
$items = $navItems[$role] ?? $navItems['guest'];

// Function to get icon for a nav item
function getNavIcon($label) {
    $icons = [
        'Home' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><polyline points="1 11 12 2 23 11" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"></polyline><path d="m5,13v7c0,1.105.895,2,2,2h10c1.105,0,2-.895,2-2v-7" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path><line x1="12" y1="22" x2="12" y2="18" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line></g></svg>',
        'Login' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><path d="m22,13.25v-2.5l-2.318-.966c-.167-.581-.395-1.135-.682-1.654l.954-2.318-1.768-1.768-2.318.954c-.518-.287-1.073-.515-1.654-.682l-.966-2.318h-2.5l-.966,2.318c-.581.167-1.135.395-1.654.682l-2.318-.954-1.768,1.768.954,2.318c-.287.518-.515,1.073-.682,1.654l-2.318.966v2.5l2.318.966c.167.581.395,1.135.682,1.654l-.954,2.318,1.768,1.768,2.318-.954c.518.287,1.073.515,1.654.682l.966,2.318h2.5l.966-2.318c.581-.167,1.135-.395,1.654-.682l2.318.954,1.768-1.768-.954-2.318c.287-.518.515-1.073.682-1.654l2.318-.966Z" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>',
        'Register' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><path d="m22,13.25v-2.5l-2.318-.966c-.167-.581-.395-1.135-.682-1.654l.954-2.318-1.768-1.768-2.318.954c-.518-.287-1.073-.515-1.654-.682l-.966-2.318h-2.5l-.966,2.318c-.581.167-1.135.395-1.654.682l-2.318-.954-1.768,1.768.954,2.318c-.287.518-.515,1.073-.682,1.654l-2.318.966v2.5l2.318.966c.167.581.395,1.135.682,1.654l-.954,2.318,1.768,1.768,2.318-.954c.518.287,1.073.515,1.654.682l.966,2.318h2.5l.966-2.318c.581-.167,1.135-.395,1.654-.682l2.318.954,1.768-1.768-.954-2.318c.287-.518.515-1.073.682-1.654l2.318-.966Z" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>',
        'Products' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><polyline points="3 14 9 14 9 17 15 17 15 14 21 14" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"></polyline><rect x="3" y="3" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></rect></g></svg>',
        'Cart' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><circle cx="8" cy="21" r="2" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><circle cx="20" cy="21" r="2" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><path d="m5.67,6h16.66l-3.5,10h-13.32l-2.16-6.5c-.14-.42-.52-.7-.96-.7h-1.34" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>',
        'Admin Panel' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><path d="m9,12l2,2 4-4m5.618-4.016A11.955,11.955 0 0112,2.944a11.955,11.955 0 01-8.618,3.04A12.02,12.02 0 003,9c0,5.591,3.824,10.29,9,11.622,5.176-1.332,9-6.03,9-11.622,0-1.042-.133-2.052-.382-3.016z" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>',
        'More' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><circle cx="12" cy="6" r="1" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><circle cx="12" cy="12" r="1" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><circle cx="12" cy="18" r="1" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle></g></svg>',
        'Table' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><rect x="3" y="3" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></rect><line x1="3" y1="9" x2="21" y2="9" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line><line x1="3" y1="15" x2="21" y2="15" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line><line x1="9" y1="3" x2="9" y2="21" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line><line x1="15" y1="3" x2="15" y2="21" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line></g></svg>',
        'Multiform' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><path d="m14,2h-8a2,2 0 00-2,2v16a2,2 0 002,2h12a2,2 0 002-2V8z" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path><polyline points="14 2 14 8 20 8" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></polyline><line x1="16" y1="13" x2="8" y2="13" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line><line x1="16" y1="17" x2="8" y2="17" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line><polyline points="10 9 9 9 8 9" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></polyline></g></svg>',
        'Logout' => '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><path d="m17,7l4,4m0,0l-4,4m4-4H7m6,4v1a3,3 0 01-3,3H6a3,3 0 01-3-3V7a3,3 0 013-3h4a3,3 0 013,3v1" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>'
    ];
    return $icons[$label] ?? '<svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><path d="m9,12h6m-6,4h6m2,5H7a2,2 0 01-2-2V5a2,2 0 012-2h5.586a1,1 0 01.707.293l5.414,5.414a1,1 0 01.293.707V19a2,2 0 01-2,2z" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path></g></svg>';
}

// Function to extract all valid pages from navItems, including nested children
function getAllPages($navItems) {
    $pages = [];
    foreach ($navItems as $item) {
        if (isset($item['link'])) {
            // If it's a full URL like logout.php, skip it for page validation
            if (!preg_match('/\.php$/', $item['link'])) {
                $pages[] = $item['link'];
            }
        }
        if (isset($item['children'])) {
            $pages = array_merge($pages, getAllPages($item['children']));
        }
    }
    return $pages;
}

// Function to get all nav items flat, including children
function getAllNavItems($navItems) {
    $items = [];
    foreach ($navItems as $item) {
        if (isset($item['link'])) {
            $items[] = $item;
        }
        if (isset($item['children'])) {
            $items = array_merge($items, getAllNavItems($item['children']));
        }
    }
    return $items;
}

if (isset($_GET['page'])) {
    $requestedPage = $_GET['page'];
    
    $allowedPages = getAllPages($items);
    $allowedPages[] = '404';
    
    if (!in_array($requestedPage, $allowedPages)) {
        header('Location: index.php?page=404');
        exit;
    }
}

$currentPage = $_GET['page'] ?? 'home';
?>

<!-- Desktop Navbar -->
<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <a class="btn btn-ghost text-xl text-red-500">daisyUI</a>
  </div>
  <div class="navbar-center hidden md:flex">
    <ul class="menu menu-horizontal px-1">
      <?php foreach ($items as $item): ?>
      <?php if (isset($item['children'])): ?>
      <li>
        <details>
          <summary><?php echo htmlspecialchars($item['label']); ?></summary>
          <ul class="p-2 bg-base-100 w-40 z-1">
      <?php foreach ($item['children'] as $child): ?>
            <li><a href="#" onclick="navigateTo('<?php echo htmlspecialchars($child['link']); ?>'); return false;"><?php echo htmlspecialchars($child['label']); ?></a></li>
      <?php endforeach; ?>
          </ul>
        </details>
      </li>
      <?php else: ?>
      <li><a href="#" onclick="navigateTo('<?php echo htmlspecialchars($item['link']); ?>'); return false;"><?php echo htmlspecialchars($item['label']); ?></a></li>
      <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="navbar-end">
   <label class="flex cursor-pointer gap-2 items-center">
      <!-- Sun icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="5"/>
        <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/>
      </svg>

      <!-- Checkbox toggle -->
      <input type="checkbox" id="theme-toggle" class="toggle" />

      <!-- Moon icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
      </svg>
    </label>
  </div>
</div>

<!-- Mobile Dock -->
<div class="dock md:hidden">
  <?php $allItems = getAllNavItems($items); ?>
  <?php foreach ($allItems as $item): ?>
  <button class="<?php echo ($item['link'] == $currentPage) ? 'dock-active' : ''; ?>" onclick="navigateTo('<?php echo htmlspecialchars($item['link']); ?>')">
    <?php echo getNavIcon($item['label']); ?>
    <span class="dock-label"><?php echo htmlspecialchars($item['label']); ?></span>
  </button>
  <?php endforeach; ?>
</div>

<script>
const htmlEl = document.documentElement;
const toggle = document.getElementById('theme-toggle');

// Load saved theme or system preference
const savedTheme = localStorage.getItem('theme');
if(savedTheme) {
  htmlEl.setAttribute('data-theme', savedTheme);
  toggle.checked = savedTheme === 'dark';
} else {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  htmlEl.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
  toggle.checked = prefersDark;
}

// Update theme when checkbox changes
toggle.addEventListener('change', () => {
  const newTheme = toggle.checked ? 'dark' : 'light';
  htmlEl.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
});

// AJAX navigation function
function navigateTo(page) {
  // If it's already a full URL (like logout.php), use it as-is
  const url = page.includes('.php') ? page : `index.php?page=${page}`;
  
  // Get the full current URL for comparison
  const currentUrl = window.location.origin + window.location.pathname + window.location.search;
  const fullUrl = url.startsWith('http') ? url : window.location.origin + '/' + url;
  
  // Prevent navigation to current page
  if (fullUrl === currentUrl) {
    console.log('Already on current page:', fullUrl);
    return;
  }
  
  // Handle logout links with AJAX call to API
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
    .catch(error => {
      console.error('Logout error:', error);
      // Fallback to direct navigation
      window.location.href = fullUrl;
    });
    return;
  }
  
  // Update URL without reloading page
  history.pushState({page: page}, '', url);
  
  // Fetch new content via AJAX
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
    // Update main content area
    const mainContent = document.getElementById('main-content');
    if (mainContent) {
      mainContent.innerHTML = html;
    } else {
      console.error('main-content element not found');
    }
    
    // Close any open dropdowns
    const details = document.querySelectorAll('details');
    details.forEach(detail => detail.removeAttribute('open'));
  })
  .catch(error => {
    console.error('Navigation error:', error);
    // Fallback to regular navigation
    window.location.href = fullUrl;
  });
}

// Handle browser back/forward buttons
window.addEventListener('popstate', function(event) {
  if (event.state && event.state.page) {
    navigateTo(event.state.page);
  }
});
</script>
