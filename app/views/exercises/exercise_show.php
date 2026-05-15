<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
        
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/2 bg-slate-900 relative min-h-[400px] flex items-center justify-center">
                <?php if (!empty($exercise['image_path'])): ?>
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($exercise['image_path']) ?>" alt="<?= htmlspecialchars($exercise['title']) ?>" class="w-full h-full object-cover opacity-90">
                <?php else: ?>
                    <span class="text-[120px]">💪</span>
                <?php endif; ?>
                
                <div class="absolute top-6 left-6 bg-orange-500 text-white font-black uppercase px-4 py-2 rounded-lg shadow-xl tracking-widest italic">
                    <?= htmlspecialchars($exercise['muscle_group_name']) ?>
                </div>
            </div>

            <div class="lg:w-1/2 p-10 flex flex-col">
                <nav class="mb-6">
                    <a href="<?= BASE_URL ?>/index.php" class="text-slate-400 hover:text-orange-500 font-bold uppercase text-xs tracking-widest transition-colors flex items-center gap-2">
                        &larr; Zpět do katalogu
                    </a>
                </nav>

                <h2 class="text-5xl font-black text-slate-900 uppercase italic tracking-tight mb-6"><?= htmlspecialchars($exercise['title']) ?></h2>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Vybavení</span>
                        <span class="font-bold text-slate-800 uppercase">⚙️ <?= htmlspecialchars($exercise['equipment']) ?></span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Obtížnost</span>
                        <span class="font-bold text-slate-800 uppercase italic text-orange-600">🔥 <?= htmlspecialchars($exercise['difficulty']) ?></span>
                    </div>
                </div>

                <div class="prose prose-slate mb-10">
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Správná technika</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        <?= nl2br(htmlspecialchars($exercise['description'])) ?>
                    </p>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="mt-auto pt-8 border-t border-slate-100 flex gap-4 items-center">
                        <button class="bg-slate-900 text-white font-black uppercase px-8 py-4 rounded-xl hover:bg-orange-500 transition-all shadow-lg flex-grow tracking-widest">
                            Přidat do tréninku
                        </button>
                        <a href="<?= BASE_URL ?>/index.php?url=exercise/edit/<?= $exercise['id'] ?>" class="p-4 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors" title="Upravit">✏️</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>