<?php require_once '../app/views/layout/header.php'; ?>    

<main class="container mx-auto px-6 py-6 flex-grow">
    
    <div class="flex justify-between items-end mb-8 border-b-2 border-slate-200 pb-4">
        <div>
            <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight">Katalog cviků</h2>
            <p class="text-slate-500 mt-1 font-medium">Inspirace pro tvůj další trénink</p>
        </div>
    </div>
    
    <?php if (empty($exercises)): ?>
        <div class="bg-white rounded-xl shadow-md p-12 text-center border border-slate-100">
            <span class="text-6xl mb-4 block">🏋️‍♂️</span>
            <h3 class="text-2xl font-black text-slate-700 mb-2 uppercase">Zatím tu nic není</h3>
            <p class="text-slate-500 font-medium">Databáze cviků je momentálně prázdná. Přidejte první cvik!</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($exercises as $exercise): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 flex flex-col group">
                    
                    <div class="relative h-48 bg-slate-900 overflow-hidden flex items-center justify-center">
                        <?php if (!empty($exercise['image_path'])): ?>
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($exercise['image_path']) ?>" alt="<?= htmlspecialchars($exercise['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                        <?php else: ?>
                            <span class="text-6xl group-hover:scale-110 transition-transform duration-500">💪</span>
                        <?php endif; ?>
                        
                        <div class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-black uppercase px-3 py-1.5 rounded-full shadow-md tracking-wider">
                            <?= htmlspecialchars($exercise['muscle_group_name'] ?? 'Neznámá partie') ?>
                        </div>
                    </div>

                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="text-xl font-black text-slate-800 mb-3 uppercase tracking-wide"><?= htmlspecialchars($exercise['title']) ?></h3>
                        
                        <div class="flex items-center gap-2 mb-4 text-xs text-slate-600 font-bold uppercase tracking-wider">
                            <span class="bg-slate-100 border border-slate-200 px-2 py-1 rounded">⚙️ <?= htmlspecialchars($exercise['equipment']) ?></span>
                            <span class="bg-slate-100 border border-slate-200 px-2 py-1 rounded">🔥 <?= htmlspecialchars($exercise['difficulty']) ?></span>
                        </div>
                        
                        <p class="text-slate-500 text-sm line-clamp-3 mb-6 flex-grow">
                            <?= htmlspecialchars($exercise['description']) ?>
                        </p>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-slate-100 mt-auto">
                            <a href="<?= BASE_URL ?>/index.php?url=exercise/show/<?= $exercise['id'] ?>" class="text-orange-500 font-black hover:text-orange-600 uppercase text-sm tracking-widest flex items-center gap-1 transition-colors">
                                Detail <span class="text-lg">&rarr;</span>
                            </a>
                            
                            <?php 
                            // Editační tlačítka vidí jen přihlášený (ideálně Admin, zatím kdokoli přihlášený)
                            if (isset($_SESSION['user_id'])): 
                            ?>
                                <div class="flex gap-4">
                                    <a href="<?= BASE_URL ?>/index.php?url=exercise/edit/<?= $exercise['id'] ?>" class="text-slate-400 hover:text-slate-800 transition-colors" title="Upravit">✏️</a>
                                    <a href="<?= BASE_URL ?>/index.php?url=exercise/delete/<?= $exercise['id'] ?>" onclick="return confirm('Opravdu chceš smazat tento cvik?')" class="text-slate-400 hover:text-rose-500 transition-colors" title="Smazat">🗑️</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>