<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="bg-slate-900 p-8 border-b-4 border-orange-500">
            <h2 class="text-3xl font-black text-white uppercase italic tracking-widest text-center">Úprava <span class="text-orange-500">cviku</span></h2>
        </div>

        <form action="<?= BASE_URL ?>/index.php?url=exercise/update/<?= $exercise['id'] ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Název cviku</label>
                <input type="text" name="title" value="<?= htmlspecialchars($exercise['title']) ?>" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Svalová partie</label>
                    <select name="muscle_group_id" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                        <?php foreach ($muscleGroups as $group): ?>
                            <option value="<?= $group['id'] ?>" <?= ($group['id'] == $exercise['muscle_group_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($group['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Obtížnost</label>
                    <select name="difficulty" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                        <option value="Začátečník" <?= ($exercise['difficulty'] === 'Začátečník') ? 'selected' : '' ?>>Začátečník</option>
                        <option value="Pokročilý" <?= ($exercise['difficulty'] === 'Pokročilý') ? 'selected' : '' ?>>Pokročilý</option>
                        <option value="Expert" <?= ($exercise['difficulty'] === 'Expert') ? 'selected' : '' ?>>Expert</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Potřebné vybavení</label>
                <select name="equipment" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                    <option value="Vlastní váha" <?= ($exercise['equipment'] === 'Vlastní váha') ? 'selected' : '' ?>>Vlastní váha</option>
                    <option value="Velká činka" <?= ($exercise['equipment'] === 'Velká činka') ? 'selected' : '' ?>>Velká činka</option>
                    <option value="Jednoručky" <?= ($exercise['equipment'] === 'Jednoručky') ? 'selected' : '' ?>>Jednoručky</option>
                    <option value="Stroj" <?= ($exercise['equipment'] === 'Stroj') ? 'selected' : '' ?>>Stroj / Kladka</option>
                    <option value="Hrazda" <?= ($exercise['equipment'] === 'Hrazda') ? 'selected' : '' ?>>Hrazda / Bradla</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Popis techniky</label>
                <textarea name="description" rows="4" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold"><?= htmlspecialchars($exercise['description']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">
                    Ilustrační obrázek <?= !empty($exercise['image_path']) ? '(Nahráním nového přepíšete původní)' : '' ?>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50">
                    <div class="space-y-1 text-center">
                        <span class="text-3xl block">🖼️</span>
                        <div class="flex text-sm text-slate-600">
                            <label for="file-upload" class="relative cursor-pointer font-black text-orange-500 hover:text-orange-600">
                                <span>Vybrat nový obrázek</span>
                                <input id="file-upload" name="image" type="file" class="sr-only">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-grow bg-slate-900 hover:bg-black text-white font-black uppercase py-4 rounded-xl shadow-lg transition-all tracking-widest">
                    Uložit změny
                </button>
                <a href="<?= BASE_URL ?>/index.php?url=exercise/show/<?= $exercise['id'] ?>" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black uppercase py-4 px-6 rounded-xl transition-all">
                    Zpět
                </a>
            </div>

        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>