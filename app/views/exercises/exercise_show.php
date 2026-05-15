<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
        
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/2 bg-slate-900 relative min-h-[400px] flex items-center justify-center">
                <?php if (!empty($exercise['image_path'])): ?>
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($exercise['image_path']) ?>" 
                         alt="<?= htmlspecialchars($exercise['title']) ?>" 
                         class="w-full h-full object-cover opacity-90">
                <?php else: ?>
                    <div class="text-center">
                        <span class="text-[120px] block mb-2">💪</span>
                        <span class="text-slate-500 font-bold uppercase tracking-widest text-xs">Bez obrázku</span>
                    </div>
                <?php endif; ?>
                
                <div class="absolute top-6 left-6 bg-orange-500 text-white font-black uppercase px-4 py-2 rounded-lg shadow-xl tracking-widest italic">
                    <?= htmlspecialchars($exercise['muscle_group_name'] ?? 'Neznámá partie') ?>
                </div>
            </div>

            <div class="lg:w-1/2 p-10 flex flex-col">
                <nav class="mb-6">
                    <a href="<?= BASE_URL ?>/index.php" class="text-slate-400 hover:text-orange-500 font-bold uppercase text-xs tracking-widest transition-colors flex items-center gap-2">
                        &larr; Zpět do katalogu
                    </a>
                </nav>

                <h2 class="text-5xl font-black text-slate-900 uppercase italic tracking-tight mb-6">
                    <?= htmlspecialchars($exercise['title']) ?>
                </h2>

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
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Správná technika provedení</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        <?= nl2br(htmlspecialchars($exercise['description'])) ?>
                    </p>
                </div>

                <?php if (!empty($exercise['video_link'])): ?>
                    <div class="mt-10 pt-8 border-t border-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Video ukázka techniky</h4>
                        
                        <?php 
                            // Magie pro převod klasického odkazu na embed formát pro YouTube
                            $video_id = "";
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $exercise['video_link'], $match)) {
                                $video_id = $match[1];
                            }
                        ?>

                        <?php if ($video_id): ?>
                            <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-lg border-4 border-slate-900 bg-slate-900">
                                <iframe class="absolute top-0 left-0 w-full h-full" 
                                        src="https://www.youtube.com/embed/<?= $video_id ?>" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
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
                        <button class="bg-slate-900 text-white font-black uppercase px-8 py-4 rounded-xl hover:bg-orange-500 transition-all shadow-lg flex-grow tracking-widest">
                            Přidat do oblíbených
                        </button>
                        
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=exercise/edit/<?= $exercise['id'] ?>" 
                               class="p-4 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors shadow-sm" 
                               title="Upravit cvik">
                                ✏️
                            </a>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" 
                           class="bg-orange-500 text-white font-black uppercase px-8 py-4 rounded-xl hover:bg-orange-600 transition-all shadow-lg flex-grow text-center tracking-widest">
                            Pro více funkcí se přihlas
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>