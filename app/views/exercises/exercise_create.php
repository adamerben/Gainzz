<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        
        <div class="bg-slate-900 p-8 border-b-4 border-orange-500">
            <h2 class="text-3xl font-black text-white uppercase italic tracking-widest text-center">Přidat nový <span class="text-orange-500">cvik</span></h2>
        </div>

        <form action="<?= BASE_URL ?>/index.php?url=exercise/store" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Název cviku</label>
                <input type="text" name="title" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold" placeholder="Např. Bench-press">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Svalová partie</label>
                    <select name="muscle_group_id" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                        <?php foreach ($muscleGroups as $group): ?>
                            <option value="<?= $group['id'] ?>"><?= htmlspecialchars($group['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Obtížnost</label>
                    <select name="difficulty" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                        <option value="Začátečník">Začátečník</option>
                        <option value="Pokročilý">Pokročilý</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Potřebné vybavení</label>
                <select name="equipment" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold">
                    <option value="Vlastní váha">Vlastní váha</option>
                    <option value="Velká činka">Velká činka</option>
                    <option value="Jednoručky">Jednoručky</option>
                    <option value="Stroj">Stroj / Kladka</option>
                    <option value="Hrazda">Hrazda / Bradla</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Popis techniky</label>
                <textarea name="description" rows="4" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold" placeholder="Popište správné provedení cviku..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Ilustrační obrázek</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50">
                    <div class="space-y-1 text-center">
                        <span class="text-3xl block">🖼️</span>
                        <div class="flex text-sm text-slate-600">
                            <label for="file-upload" class="relative cursor-pointer font-black text-orange-500 hover:text-orange-600">
                                <span>Nahrajte soubor</span>
                                <input id="file-upload" name="image" type="file" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-slate-400">PNG, JPG do 2MB</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-grow bg-orange-500 hover:bg-orange-600 text-white font-black uppercase py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 tracking-widest">
                    Uložit cvik do databáze
                </button>
                <a href="<?= BASE_URL ?>/index.php" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black uppercase py-4 px-6 rounded-xl transition-all">
                    Zrušit
                </a>
            </div>

        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>