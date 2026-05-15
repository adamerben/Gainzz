<?php require_once '../app/views/layout/header.php'; ?>

<main class="min-h-screen bg-slate-950 text-slate-100">
    <section class="mx-auto max-w-4xl px-6 py-12">
        <div class="mb-8 rounded-3xl border border-orange-400/30 bg-slate-900/80 p-8 shadow-2xl shadow-orange-500/10">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <p class="mb-3 inline-flex rounded-full bg-orange-500/10 px-4 py-1 text-sm font-semibold uppercase tracking-[0.3em] text-orange-300">Uživatelský profil</p>
                    <h1 class="text-4xl font-semibold text-white">Vítejte, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
                    <p class="mt-4 text-slate-300">Spravujte svůj profil a sledujte své BMI.</p>
                </div>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_1fr]">
                <article class="space-y-6 rounded-3xl bg-slate-900/80 p-8 ring-1 ring-orange-400/10">
                    <h2 class="text-2xl font-semibold text-white">Úprava profilu</h2>
                    <form action="<?= BASE_URL ?>/index.php?url=user/updateProfile" method="POST" class="space-y-6">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-slate-300">Váha (kg)</label>
                            <input type="number" step="0.1" id="weight" name="weight" value="<?= htmlspecialchars($user['weight'] ?? '') ?>" class="mt-1 block w-full rounded-2xl border border-slate-600 bg-slate-800 px-4 py-3 text-white placeholder-slate-400 focus:border-orange-500 focus:ring-orange-500" required>
                        </div>
                        <div>
                            <label for="height" class="block text-sm font-medium text-slate-300">Výška (cm)</label>
                            <input type="number" id="height" name="height" value="<?= htmlspecialchars($user['height'] ?? '') ?>" class="mt-1 block w-full rounded-2xl border border-slate-600 bg-slate-800 px-4 py-3 text-white placeholder-slate-400 focus:border-orange-500 focus:ring-orange-500" required>
                        </div>
                        <div>
                            <label for="bio" class="block text-sm font-medium text-slate-300">Bio</label>
                            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full rounded-2xl border border-slate-600 bg-slate-800 px-4 py-3 text-white placeholder-slate-400 focus:border-orange-500 focus:ring-orange-500"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 shadow-lg shadow-orange-500/20 transition hover:bg-orange-400">Uložit změny</button>
                    </form>
                </article>

                <aside class="space-y-6 rounded-3xl bg-slate-900/80 p-8 ring-1 ring-orange-400/10">
                    <h2 class="text-2xl font-semibold text-white">BMI Kalkulačka</h2>
                    <?php if ($bmi !== null): ?>
                        <div class="space-y-4">
                            <div class="rounded-3xl bg-slate-950/80 p-6 text-center">
                                <p class="text-4xl font-bold text-orange-300"><?= $bmi ?></p>
                                <p class="text-sm text-slate-400 uppercase tracking-[0.2em]">Vaše BMI</p>
                            </div>
                            <div class="rounded-3xl bg-slate-950/80 p-6 text-center">
                                <p class="text-lg font-semibold text-white"><?= htmlspecialchars($bmiCategory) ?></p>
                                <p class="text-sm text-slate-400 uppercase tracking-[0.2em]">Kategorie</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="rounded-3xl bg-slate-950/80 p-6 text-center">
                            <p class="text-lg text-slate-400">Vyplňte váhu a výšku pro výpočet BMI.</p>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                <a href="<?= BASE_URL ?>/index.php" class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-slate-950 shadow-lg shadow-orange-500/20 transition hover:bg-orange-400">Zpět na přehled</a>
                <span class="text-sm text-slate-400">Správa uživatelského profilu</span>
            </div>
        </div>
    </section>
</main>

<div class="mt-12">
    <h3 class="text-2xl font-black text-slate-900 uppercase italic mb-6">Můj tréninkový <span class="text-orange-500">plán</span></h3>
    <?php if (empty($favoriteExercises)): ?>
        <p class="text-slate-500 font-medium bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">Zatím nemáš vybrané žádné cviky. Koukni do katalogu!</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($favoriteExercises as $fav): ?>
                <a href="<?= BASE_URL ?>/index.php?url=exercise/show/<?= $fav['id'] ?>" class="flex items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-orange-500 transition-colors group">
                    <div class="w-16 h-16 bg-slate-900 rounded-xl overflow-hidden flex-shrink-0">
                        <?php if ($fav['image_path']): ?>
                            <img src="<?= BASE_URL ?>/<?= $fav['image_path'] ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="flex items-center justify-center h-full text-2xl">💪</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-800 uppercase group-hover:text-orange-500 transition-colors"><?= htmlspecialchars($fav['title']) ?></h4>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest"><?= htmlspecialchars($fav['muscle_group_name']) ?></span>
                    </div>
                    <span class="ml-auto text-orange-500 font-black text-xl mr-2">→</span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
