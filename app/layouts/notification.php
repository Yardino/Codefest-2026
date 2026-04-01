<?php
$rawMessage = $_SESSION['notificationMessage'] ?? null;
$rawType = $_SESSION['notificationType'] ?? 'info';

unset($_SESSION['notificationMessage'], $_SESSION['notificationType']);

if (!is_scalar($rawMessage)) {
    return;
}

$message = trim((string) $rawMessage);
if ($message === '') {
    return;
}

$type = is_scalar($rawType) ? strtolower(trim((string) $rawType)) : 'info';
$typeAliases = [
    'danger' => 'error',
    'fail' => 'error',
    'failed' => 'error',
    'ok' => 'success',
];
$type = $typeAliases[$type] ?? $type;

$allowedTypes = ['success', 'error', 'warning', 'info'];
if (!in_array($type, $allowedTypes, true)) {
    $type = 'info';
}

$titles = [
    'success' => 'Success',
    'error' => 'Error',
    'warning' => 'Warning',
    'info' => 'Info',
];

$icons = [
    'success' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6 9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'error' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m15 9-6 6m0-6 6 6" stroke-linecap="round"/></svg>',
    'warning' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 3 2.6 19a1 1 0 0 0 .86 1.5h17.08A1 1 0 0 0 21.4 19L12 3Z" stroke-linejoin="round"/><path d="M12 9v4" stroke-linecap="round"/><path d="M12 17h.01" stroke-linecap="round"/></svg>',
    'info' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 10v6" stroke-linecap="round"/><path d="M12 7h.01" stroke-linecap="round"/></svg>',
];
?>

<style>
  .session-notification {
    position: fixed;
    top: calc(env(safe-area-inset-top, 0px) + 1rem);
    left: 50%;
    z-index: 80;
    width: min(calc(100vw - 1.5rem), 32rem);
    transform: translateX(-50%);
    pointer-events: none;
  }

  .session-notification__alert {
    --notification-accent: var(--color-info);
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    padding: 1rem;
    border: 1px solid color-mix(in oklab, var(--notification-accent) 28%, transparent);
    border-radius: var(--radius-box);
    background: color-mix(in oklab, var(--notification-accent) 12%, var(--color-base-100));
    color: var(--color-base-content);
    box-shadow: 0 18px 45px color-mix(in oklab, var(--color-base-content) 16%, transparent);
    pointer-events: auto;
    animation: session-notification-fade 6s ease forwards;
  }

  .session-notification__alert--success {
    --notification-accent: var(--color-success);
  }

  .session-notification__alert--error {
    --notification-accent: var(--color-error);
  }

  .session-notification__alert--warning {
    --notification-accent: var(--color-warning);
  }

  .session-notification__alert--info {
    --notification-accent: var(--color-info);
  }

  .session-notification__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 2.75rem;
    height: 2.75rem;
    border-radius: calc(var(--radius-box) - 0.375rem);
    background: color-mix(in oklab, var(--notification-accent) 18%, var(--color-base-100));
    color: var(--notification-accent);
  }

  .session-notification__icon svg {
    width: 1.375rem;
    height: 1.375rem;
  }

  .session-notification__body {
    flex: 1;
    min-width: 0;
  }

  .session-notification__title {
    margin-bottom: 0.25rem;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: color-mix(in oklab, var(--notification-accent) 55%, var(--color-base-content));
  }

  .session-notification__message {
    font-size: 0.95rem;
    line-height: 1.45;
    word-break: break-word;
  }

  .session-notification__close {
    flex-shrink: 0;
    width: 2rem;
    min-width: 2rem;
    height: 2rem;
    min-height: 2rem;
    padding: 0;
    border-color: transparent;
    background: transparent;
  }

  .session-notification__close:hover {
    background: color-mix(in oklab, var(--notification-accent) 10%, transparent);
  }

  @media (min-width: 768px) {
    .session-notification {
      left: auto;
      right: 1rem;
      transform: none;
      width: min(32rem, calc(100vw - 2rem));
    }
  }

  @keyframes session-notification-fade {
    0%, 85% {
      opacity: 1;
      transform: translateY(0);
    }

    100% {
      opacity: 0;
      transform: translateY(-0.75rem);
      visibility: hidden;
    }
  }
</style>

<div class="session-notification" aria-live="polite" aria-atomic="true">
  <div class="session-notification__alert session-notification__alert--<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>" role="alert">
    <div class="session-notification__icon">
      <?= $icons[$type] ?>
    </div>

    <div class="session-notification__body">
      <p class="session-notification__title"><?= htmlspecialchars($titles[$type], ENT_QUOTES, 'UTF-8') ?></p>
      <p class="session-notification__message"><?= nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) ?></p>
    </div>

    <button
      type="button"
      class="btn btn-ghost btn-sm session-notification__close"
      onclick="this.closest('.session-notification').remove()"
      aria-label="Dismiss notification"
    >
      &times;
    </button>
  </div>
</div>
