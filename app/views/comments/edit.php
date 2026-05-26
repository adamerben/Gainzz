<?php require_once '../app/views/layout/header.php'; ?>
<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden p-8">
        <h2 class="text-3xl font-black text-slate-900 uppercase italic mb-6">Úprava <span
                class="text-orange-500">komentáře</span></h2>
        <form action="<?= BASE_URL ?>/index.php?url=comment/update/<?= $comment['id'] ?>" method="POST">
            <textarea name="content" rows="4" required
                class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-orange-500 focus:outline-none transition-colors font-bold mb-4"><?= htmlspecialchars($comment['content']) ?></textarea>
            <div class="flex gap-4">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-black py-3 px-8 rounded-xl transition-all uppercase tracking-widest">Uložit
                    změny</button>
                <a href="<?= BASE_URL ?>/index.php?url=exercise/show/<?= $comment['exercise_id'] ?>"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-black py-3 px-8 rounded-xl transition-all uppercase tracking-widest">Zpět</a>
            </div>
        </form>
    </div>
</main>
<?php require_once '../app/views/layout/footer.php'; ?>