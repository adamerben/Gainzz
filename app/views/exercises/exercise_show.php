<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">

        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/2 bg-slate-900 relative min-h-[400px] flex items-center justify-center">
                <?php if (!empty($exercise['image_path'])): ?>
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($exercise['image_path']) ?>"
                        alt="<?= htmlspecialchars($exercise['title']) ?>" class="w-full h-full object-cover opacity-90">
                <?php else: ?>
                    <div class="text-center">
                        <span class="text-[120px] block mb-2">💪</span>
                        <span class="text-slate-500 font-bold uppercase tracking-widest text-xs">Bez obrázku</span>
                    </div>
                <?php endif; ?>

                <div
                    class="absolute top-6 left-6 bg-orange-500 text-white font-black uppercase px-4 py-2 rounded-lg shadow-xl tracking-widest italic">
                    <?= htmlspecialchars($exercise['muscle_group_name'] ?? 'Neznámá partie') ?>
                </div>
            </div>

            <div class="lg:w-1/2 p-10 flex flex-col">
                <nav class="mb-6">
                    <a href="<?= BASE_URL ?>/index.php"
                        class="text-slate-400 hover:text-orange-500 font-bold uppercase text-xs tracking-widest transition-colors flex items-center gap-2">
                        &larr; Zpět do katalogu
                    </a>
                </nav>

                <h2 class="text-5xl font-black text-slate-900 uppercase italic tracking-tight mb-6">
                    <?= htmlspecialchars($exercise['title']) ?>
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Vybavení</span>
                        <span class="font-bold text-slate-800 uppercase">⚙️
                            <?= htmlspecialchars($exercise['equipment']) ?></span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Obtížnost</span>
                        <span class="font-bold text-slate-800 uppercase italic text-orange-600">🔥
                            <?= htmlspecialchars($exercise['difficulty']) ?></span>
                    </div>
                </div>

                <div class="prose prose-slate mb-10">
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Správná technika</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        <?= nl2br(htmlspecialchars($exercise['description'])) ?>
                    </p>
                </div>

                <?php if (!empty($exercise['video_link'])): ?>
                    <div class="mt-4 mb-8 pt-8 border-t border-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Video ukázka techniky
                        </h4>
                        <?php
                        $video_id = "";
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $exercise['video_link'], $match)) {
                            $video_id = $match[1];
                        }
                        ?>
                        <?php if ($video_id): ?>
                            <div
                                class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-lg border-4 border-slate-900 bg-slate-900">
                                <iframe class="absolute top-0 left-0 w-full h-full"
                                    src="https://www.youtube.com/embed/<?= $video_id ?>" frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($exercise['video_link']) ?>" target="_blank"
                                class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-6 py-3 rounded-xl transition-colors">
                                <span>📺 Sledovat video na externím webu</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-auto pt-8 border-t border-slate-100 flex gap-4 items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=favorite/toggle/<?= $exercise['id'] ?>"
                                class="<?= $isFavorite ? 'bg-orange-600' : 'bg-slate-900' ?> text-white font-black uppercase px-8 py-4 rounded-xl hover:bg-orange-500 transition-all shadow-lg flex-grow tracking-widest text-center">
                                <?= $isFavorite ? '❤️ V mém tréninku' : '🤍 Přidat do oblíbených' ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=exercise/edit/<?= $exercise['id'] ?>"
                                class="p-4 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors shadow-sm"
                                title="Upravit cvik">✏️</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                            class="bg-orange-500 text-white font-black uppercase px-8 py-4 rounded-xl hover:bg-orange-600 transition-all shadow-lg flex-grow text-center tracking-widest">
                            Pro uložení se přihlas
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 p-6 md:p-10 border-t-4 border-slate-100">
            <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tight mb-8">Diskuze k <span
                    class="text-orange-500">cviku</span></h3>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="POST"
                    class="mb-10 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <input type="hidden" name="exercise_id" value="<?= $exercise['id'] ?>">
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Přidat vlastní tip
                        nebo dotaz</label>
                    <textarea name="content" rows="3" required
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold"
                        placeholder="Jaké máš s tímto cvikem zkušenosti?"></textarea>
                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-slate-900 hover:bg-orange-500 text-white font-black py-3 px-8 rounded-xl shadow-lg transition-all uppercase tracking-widest hover:-translate-y-1">
                            Odeslat komentář
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="mb-10 bg-orange-100 border-l-4 border-orange-500 p-4 rounded-r-xl">
                    <p class="text-orange-800 font-bold text-sm">Pro přidání komentáře se musíte <a
                            href="<?= BASE_URL ?>/index.php?url=auth/login"
                            class="underline hover:text-orange-900">přihlásit</a>.</p>
                </div>
            <?php endif; ?>

            <div class="space-y-6">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-slate-200 text-slate-600 rounded-full flex items-center justify-center font-black text-xl uppercase shadow-inner">
                                <?= substr(htmlspecialchars($comment['author_name'] ?? '?'), 0, 1) ?>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-baseline justify-between mb-2">
                                    <h4 class="text-slate-900 font-black tracking-wide">
                                        <?= htmlspecialchars($comment['author_name'] ?? 'Neznámý') ?></h4>

                                    <div class="flex items-center gap-4">
                                        <span
                                            class="text-xs font-bold text-slate-400"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>

                                        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'))): ?>
                                            <a href="<?= BASE_URL ?>/index.php?url=comment/edit/<?= $comment['id'] ?>"
                                                class="text-xs text-slate-400 hover:text-orange-500 font-bold uppercase tracking-wider transition-colors flex items-center gap-1">
                                                ✏️ Upravit
                                            </a>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'))): ?>
                                            <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $comment['id'] ?>"
                                                onclick="return confirm('Opravdu chcete smazat tento komentář?')"
                                                class="text-xs text-slate-400 hover:text-rose-500 font-bold uppercase tracking-wider transition-colors flex items-center gap-1">
                                                🗑️ Smazat
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                </div>
                                <p class="text-slate-600 font-medium leading-relaxed text-sm">
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <span class="text-4xl block mb-2">💬</span>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Zatím tu nejsou žádné
                            komentáře. Buď první!</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>