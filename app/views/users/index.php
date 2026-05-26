<?php require_once '../app/views/layout/header.php'; ?>
<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden p-8">
        <h2 class="text-3xl font-black text-slate-900 uppercase italic mb-6">Správa <span
                class="text-orange-500">uživatelů</span></h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-500 text-xs uppercase tracking-widest">
                    <th class="p-4 rounded-tl-xl">ID</th>
                    <th class="p-4">Jméno</th>
                    <th class="p-4">Role</th>
                    <th class="p-4 rounded-tr-xl">Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="p-4 font-bold text-slate-400">#<?= $u['id'] ?></td>
                        <td class="p-4 font-bold text-slate-800"><?= htmlspecialchars($u['username']) ?></td>
                        <td
                            class="p-4 font-bold <?= $u['role'] === 'admin' ? 'text-orange-500' : 'text-slate-500' ?> uppercase text-xs tracking-widest">
                            <?= $u['role'] ?></td>
                        <td class="p-4">
                            <?php if ($u['role'] !== 'admin'): ?>
                                <a href="<?= BASE_URL ?>/index.php?url=user/delete/<?= $u['id'] ?>"
                                    onclick="return confirm('Opravdu smazat tohoto uživatele?')"
                                    class="text-xs text-rose-500 font-bold uppercase hover:underline">Smazat</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require_once '../app/views/layout/footer.php'; ?>