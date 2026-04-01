<?php
// $_SESSION['notificationType'] = 'warning';
// $_SESSION['notificationMessage'] = 'Demo notification: the shared session handler is working on the login page.';
?>
<section class="w-full px-0 py-4 sm:px-2 sm:py-6 md:px-0 md:py-10">
  <div class="mx-auto w-full max-w-[34rem] rounded-[1.75rem] border border-base-content/30 bg-base-100/95 px-6 py-7 shadow-xl md:px-10 md:py-8">
    <div class="space-y-8">
      <div class="space-y-1">
        <h1 class="text-[1.85rem] font-semibold text-base-content">Inloggen</h1>
      </div>

      <div
        id="loginSummary"
        class="hidden min-h-12 items-center rounded-2xl border border-base-content/25 px-4 py-3 text-[0.95rem] font-medium text-base-content/90"
        role="alert"
      >
        <span id="loginSummaryText"></span>
      </div>

      <form id="loginForm" method="POST" novalidate class="space-y-5">
        <div>
          <label for="loginIdentifier" class="mb-2 block text-[0.86rem] font-semibold text-base-content/90">E-mail of gebruikersnaam</label>
          <input
            id="loginIdentifier"
            type="text"
            name="email"
            autocomplete="username"
            class="input input-bordered h-14 w-full rounded-2xl border-base-content/30 bg-transparent px-4 shadow-none focus:border-base-content/50 focus:outline-none"
            required
          />
          <p id="loginIdentifierError" class="mt-2 hidden text-sm text-error"></p>
        </div>

        <div>
          <label for="loginPassword" class="mb-2 block text-[0.86rem] font-semibold text-base-content/90">Wachtwoord</label>
          <input
            id="loginPassword"
            type="password"
            name="password"
            autocomplete="current-password"
            class="input input-bordered h-14 w-full rounded-2xl border-base-content/30 bg-transparent px-4 shadow-none focus:border-base-content/50 focus:outline-none"
            required
          />
          <p id="loginPasswordError" class="mt-2 hidden text-sm text-error"></p>
        </div>

        <div class="grid gap-4 pt-1 sm:grid-cols-2">
          <button id="loginSubmit" type="submit" class="btn btn-neutral min-h-[3.35rem] w-full rounded-2xl font-semibold shadow-none">
            Inloggen
          </button>
          <button id="loginCancel" type="reset" class="btn btn-outline min-h-[3.35rem] w-full rounded-2xl font-semibold shadow-none">
            Annuleren
          </button>
        </div>
      </form>

      <div class="space-y-3 border-t border-base-content/15 pt-5">
        <div class="flex flex-col gap-1 text-[0.95rem] text-base-content/70 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
          <span>Wachtwoord vergeten?</span>
          <button type="button" id="resetFlowLink" class="bg-transparent p-0 text-left font-bold text-base-content hover:underline">
            Reset
          </button>
        </div>

        <div class="flex flex-col gap-1 text-[0.95rem] text-base-content/70 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
          <span>Uitnodiging ontvangen?</span>
          <a href="index.php?page=activate" class="font-bold text-base-content hover:underline" onclick="navigateTo('activate'); return false;">
            Account activeren
          </a>
        </div>

        <p class="pt-1 text-xs leading-6 text-base-content/55">
          Beveiliging: na inloggen kan 2FA gevraagd worden.
        </p>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
  const form = document.getElementById('loginForm');
  if (!form) {
    return;
  }

  const storageKey = 'rah-login-ui-throttle';
  const maxFailedAttempts = 5;
  const lockDurationMs = 60 * 1000;
  const summary = document.getElementById('loginSummary');
  const summaryText = document.getElementById('loginSummaryText');
  const submitButton = document.getElementById('loginSubmit');
  const cancelButton = document.getElementById('loginCancel');
  const resetFlowLink = document.getElementById('resetFlowLink');
  const fields = {
    email: {
      input: document.getElementById('loginIdentifier'),
      error: document.getElementById('loginIdentifierError'),
    },
    password: {
      input: document.getElementById('loginPassword'),
      error: document.getElementById('loginPasswordError'),
    },
  };

  function setSummary(message, type = 'error') {
    summary.className = `flex min-h-12 items-center rounded-2xl border px-4 py-3 text-[0.95rem] font-medium ${
      type === 'success'
        ? 'border-success/60 text-success'
        : 'border-error/60 text-error'
    }`;
    summary.classList.remove('hidden');
    summaryText.textContent = message;
  }

  function clearSummary() {
    summary.className = 'hidden min-h-12 items-center rounded-2xl border border-base-content/25 px-4 py-3 text-[0.95rem] font-medium text-base-content/90';
    summaryText.textContent = '';
  }

  function clearFieldErrors() {
    Object.values(fields).forEach(({ input, error }) => {
      input.classList.remove('input-error');
      input.removeAttribute('aria-invalid');
      error.textContent = '';
      error.classList.add('hidden');
    });
  }

  function getThrottleState() {
    try {
      const rawValue = window.localStorage.getItem(storageKey);
      const parsed = rawValue ? JSON.parse(rawValue) : {};
      return {
        failures: Number(parsed.failures || 0),
        lockedUntil: Number(parsed.lockedUntil || 0),
      };
    } catch (error) {
      return { failures: 0, lockedUntil: 0 };
    }
  }

  function setThrottleState(state) {
    window.localStorage.setItem(storageKey, JSON.stringify(state));
  }

  function clearThrottleState() {
    window.localStorage.removeItem(storageKey);
  }

  function getRemainingLockSeconds() {
    const { lockedUntil } = getThrottleState();
    return Math.max(0, Math.ceil((lockedUntil - Date.now()) / 1000));
  }

  function registerFailedAttempt() {
    const state = getThrottleState();
    const nextFailures = state.failures + 1;

    if (nextFailures >= maxFailedAttempts) {
      setThrottleState({
        failures: 0,
        lockedUntil: Date.now() + lockDurationMs,
      });
      return true;
    }

    setThrottleState({
      failures: nextFailures,
      lockedUntil: 0,
    });
    return false;
  }

  function syncLockedState() {
    const remainingSeconds = getRemainingLockSeconds();
    const isLocked = remainingSeconds > 0;

    submitButton.disabled = isLocked;

    if (isLocked) {
      setSummary(`Je hebt meerdere keren een onjuiste combinatie ingevuld. Wacht ${remainingSeconds} seconden voordat je opnieuw probeert.`, 'error');
      return true;
    }

    const state = getThrottleState();
    if (state.lockedUntil && remainingSeconds === 0) {
      clearThrottleState();
    }

    return false;
  }

  function applyFieldErrors(fieldErrors) {
    let firstInvalidField = null;

    Object.entries(fieldErrors || {}).forEach(([name, message]) => {
      const field = fields[name];
      if (!field) {
        return;
      }

      field.input.classList.add('input-error');
      field.input.setAttribute('aria-invalid', 'true');
      field.error.textContent = message;
      field.error.classList.remove('hidden');

      if (!firstInvalidField) {
        firstInvalidField = field.input;
      }
    });

    if (firstInvalidField) {
      firstInvalidField.focus();
    }
  }

  function validateForm() {
    const values = {
      email: fields.email.input.value.trim(),
      password: fields.password.input.value,
    };
    const fieldErrors = {};

    if (!values.email) {
      fieldErrors.email = 'Vul je e-mailadres of gebruikersnaam in.';
    }

    if (!values.password) {
      fieldErrors.password = 'Vul je wachtwoord in.';
    }

    return fieldErrors;
  }

  async function submitLogin(event) {
    event.preventDefault();
    clearSummary();
    clearFieldErrors();

    if (syncLockedState()) {
      return;
    }

    const fieldErrors = validateForm();
    if (Object.keys(fieldErrors).length > 0) {
      setSummary('Controleer je invoer en probeer het opnieuw.', 'error');
      applyFieldErrors(fieldErrors);
      return;
    }

    submitButton.disabled = true;
    submitButton.classList.add('loading');

    try {
      const response = await fetch('server/api/login.php', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(form)
      });

      let data = {};
      try {
        data = await response.json();
      } catch (error) {
        data = {};
      }

      if (!response.ok || !data.success) {
        const isNowLocked = registerFailedAttempt();
        if (isNowLocked) {
          syncLockedState();
        } else {
          setSummary('Deze combinatie klopt niet.', 'error');
          applyFieldErrors({
            email: 'Controleer deze combinatie.',
            password: 'Controleer deze combinatie.',
          });
        }

        return;
      }

      clearThrottleState();
      setSummary('Inloggen gelukt. Je wordt doorgestuurd.', 'success');
      setTimeout(() => {
        navigateTo(data.redirect || 'index.php?page=dashboard');
      }, 250);
    } catch (error) {
      setSummary('We konden je nu niet inloggen. Probeer het opnieuw.', 'error');
    } finally {
      submitButton.disabled = false;
      submitButton.classList.remove('loading');
    }
  }

  if (resetFlowLink) {
    resetFlowLink.addEventListener('click', function () {
      setSummary('De reset-flow wordt vanaf hier gestart zodra dit scherm is gekoppeld.', 'success');
    });
  }

  if (cancelButton) {
    cancelButton.addEventListener('click', function () {
      clearSummary();
      clearFieldErrors();
      clearThrottleState();
      fields.email.input.value = '';
      fields.password.input.value = '';
      fields.email.input.focus();
    });
  }

  syncLockedState();
  window.setInterval(syncLockedState, 1000);
  form.addEventListener('submit', submitLogin);
})();
</script>
