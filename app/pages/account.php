<?php
$user = $_SESSION['user'] ?? [];
$displayName = trim((string) ($user['name'] ?? ''));
$displayEmail = trim((string) ($user['email'] ?? ''));

if ($displayName === '') {
    $displayName = 'Gebruiker';
}

if ($displayEmail === '') {
    $displayEmail = 'gebruiker@example.com';
}
?>

<section class="w-full space-y-4">
  <div>
    <h1 class="text-sm font-semibold text-base-content">Account</h1>
  </div>

  <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_18.5rem]">
    <section class="rounded-box border border-base-300 bg-base-100 p-4 shadow-sm">
      <div class="space-y-4">
        <div>
          <p class="text-xs font-semibold text-base-content">Profiel</p>
        </div>

        <div class="space-y-3">
          <div>
            <label class="mb-1 block text-[11px] text-base-content/70" for="account-name">Naam</label>
            <input id="account-name" class="input input-bordered w-full" type="text" value="<?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>">
          </div>

          <div>
            <label class="mb-1 block text-[11px] text-base-content/70" for="account-email">E-mail</label>
            <input id="account-email" class="input input-bordered w-full" type="email" value="<?= htmlspecialchars($displayEmail, ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <div>
          <button type="button" class="btn btn-neutral btn-sm min-w-28">Opslaan</button>
        </div>
      </div>
    </section>

    <section class="rounded-box border border-base-300 bg-base-100 p-4 shadow-sm">
      <div class="space-y-4">
        <div>
          <p class="text-xs font-semibold text-base-content">Beveiliging</p>
        </div>

        <div class="space-y-3">
          <div class="space-y-2">
            <p class="text-[11px] text-base-content/70">2FA status</p>
            <span class="badge badge-neutral badge-lg px-4">Actief</span>
          </div>

          <div class="grid gap-2 sm:grid-cols-2">
            <button type="button" class="btn btn-outline btn-sm">Herstelcodes</button>
            <button type="button" class="btn btn-outline btn-sm">2FA opnieuw</button>
          </div>

          <div class="divider my-1"></div>

          <div class="space-y-3">
            <div>
              <label class="mb-1 block text-[11px] text-base-content/70" for="account-current-password">Huidig</label>
              <input id="account-current-password" class="input input-bordered w-full" type="password">
            </div>

            <div>
              <label class="mb-1 block text-[11px] text-base-content/70" for="account-new-password">Nieuw</label>
              <input id="account-new-password" class="input input-bordered w-full" type="password">
            </div>

            <div>
              <label class="mb-1 block text-[11px] text-base-content/70" for="account-repeat-password">Herhaal</label>
              <input id="account-repeat-password" class="input input-bordered w-full" type="password">
            </div>
          </div>
        </div>

        <div class="flex flex-wrap gap-2">
          <button type="button" class="btn btn-neutral btn-sm min-w-28">Opslaan</button>
          <button type="button" class="btn btn-outline btn-sm min-w-28" onclick="navigateTo('logout.php')">Uitloggen</button>
        </div>
      </div>
    </section>
  </div>
</section>
