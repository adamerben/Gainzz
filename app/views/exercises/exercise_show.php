<?php require_once '../app/views/layout/header.php'; ?>

<main class="min-h-screen bg-slate-950 text-slate-100">
    <section class="mx-auto max-w-5xl px-6 py-12">
        <div class="mb-8 rounded-3xl border border-orange-400/30 bg-slate-900/80 p-8 shadow-2xl shadow-orange-500/10">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="mb-3 inline-flex rounded-full bg-orange-500/10 px-4 py-1 text-sm font-semibold uppercase tracking-[0.3em] text-orange-300">Detail cviku</p>
                    <h1 class="text-4xl font-semibold text-white"><?= htmlspecialchars($exercise['title']) ?></h1>
                    <p class="mt-4 text-slate-300">Svalová partie: <span class="font-semibold text-orange-300"><?= htmlspecialchars($exercise['muscle_group_name'] ?? 'Nezařazeno') ?></span></p>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-900/80 p-5 ring-1 ring-orange-400/10">
                            <h2 class="text-sm uppercase tracking-[0.2em] text-slate-400">Vybavení</h2>
                            <p class="mt-3 text-lg font-medium text-slate-100"><?= htmlspecialchars($exercise['equipment']) ?></p>
                        </div>
                        <div class="rounded-3xl bg-slate-900/80 p-5 ring-1 ring-orange-400/10">
                            <h2 class="text-sm uppercase tracking-[0.2em] text-slate-400">Obtížnost</h2>
                            <p class="mt-3 text-lg font-medium text-slate-100"><?= htmlspecialchars($exercise['difficulty']) ?></p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($exercise['image_path'])): ?>
                    <div class="overflow-hidden rounded-[2rem] border border-orange-400/10 bg-slate-950/70 shadow-xl shadow-orange-500/10">
                        <img src="<?= htmlspecialchars(BASE_URL . '/' . $exercise['image_path']) ?>" alt="<?= htmlspecialchars($exercise['title']) ?>" class="h-full w-full object-cover" />
                    </div>
                <?php else: ?>
                    <div class="flex h-full items-center justify-center rounded-[2rem] border border-orange-400/10 bg-slate-950/70 p-12 text-center text-orange-200 shadow-xl shadow-orange-500/10">
                        <span class="text-sm uppercase tracking-[0.25em] text-orange-300">Obrázek není k dispozici</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <article class="space-y-6 rounded-3xl bg-slate-900/80 p-8 ring-1 ring-orange-400/10">
                    <h2 class="text-2xl font-semibold text-white">Popis cviku</h2>
                    <p class="leading-8 text-slate-300"><?= nl2br(htmlspecialchars($exercise['description'])) ?></p>
                </article>

                <aside class="space-y-6 rounded-3xl bg-slate-900/80 p-8 ring-1 ring-orange-400/10">
                    <?php if (!empty($exercise['video_link'])): ?>
                        <div>
                            <h3 class="text-sm uppercase tracking-[0.2em] text-slate-400">Video</h3>
                            <a href="<?= htmlspecialchars($exercise['video_link']) ?>" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-2 rounded-full border border-orange-400/30 bg-orange-500/10 px-4 py-3 text-sm font-medium text-orange-200 transition hover:bg-orange-500/20">
                                <span>Otevřít video</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div>
                        <h3 class="text-sm uppercase tracking-[0.2em] text-slate-400">Informace</h3>
                        <ul class="mt-4 space-y-3 text-slate-300">
                            <li class="flex items-center justify-between rounded-2xl bg-slate-950/80 px-4 py-3">
                                <span class="text-sm text-slate-400">ID cviku</span>
                                <span class="font-medium text-white"><?= htmlspecialchars($exercise['id']) ?></span>
                            </li>
                            <li class="flex items-center justify-between rounded-2xl bg-slate-950/80 px-4 py-3">
                                <span class="text-sm text-slate-400">Svalová partie</span>
                                <span class="font-medium text-orange-300"><?= htmlspecialchars($exercise['muscle_group_name'] ?? 'Nezařazeno') ?></span>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                <a href="<?= BASE_URL ?>/index.php" class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 shadow-lg shadow-orange-500/20 transition hover:bg-orange-400">Zpět na přehled</a>
                <span class="text-sm text-slate-400">Zobrazení detailu cviku</span>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
