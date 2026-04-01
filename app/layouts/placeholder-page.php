<?php
$placeholderTitle = $placeholderTitle ?? 'Pagina';
$placeholderDescription = $placeholderDescription ?? 'Deze module wordt hier uitgewerkt.';
$placeholderMeta = $placeholderMeta ?? [];
?>

<section class="w-full max-w-5xl">
  <div class="hero rounded-box border border-base-300 bg-base-100 shadow-xl">
    <div class="hero-content w-full flex-col items-start gap-8 px-6 py-10 md:px-10">
      <div class="space-y-4">
        <span class="badge badge-outline badge-primary">Recruitment Allocation Hub</span>
        <div class="space-y-2">
          <h1 class="text-3xl font-bold md:text-4xl"><?= htmlspecialchars($placeholderTitle, ENT_QUOTES, 'UTF-8') ?></h1>
          <p class="max-w-2xl text-base-content/70"><?= htmlspecialchars($placeholderDescription, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
      </div>

      <?php if ($placeholderMeta): ?>
        <div class="grid w-full gap-4 md:grid-cols-3">
          <?php foreach ($placeholderMeta as $item): ?>
            <div class="rounded-box border border-base-300 bg-base-200/60 p-4">
              <p class="text-xs uppercase tracking-[0.22em] text-base-content/50"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></p>
              <p class="mt-2 text-lg font-semibold"><?= htmlspecialchars($item['value'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
