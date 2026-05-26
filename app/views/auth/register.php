<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-lg">
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-black tracking-widest text-slate-900 uppercase italic">Nová <span
                    class="text-orange-500">registrace</span></h2>
            <p class="text-slate-500 font-medium mt-2">Vytvořte si účet a začněte budovat svůj trénink.</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl shadow-xl p-8 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="space-y-6">

                <div>
                    <label for="username"
                        class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Uživatelské jméno
                        <span class="text-orange-500">*</span></label>
                    <input type="text" id="username" name="username" required
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-bold focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label for="email"
                        class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">E-mail <span
                            class="text-orange-500">*</span></label>
                    <input type="email" id="email" name="email" required
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-bold focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label for="password"
                        class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Heslo <span
                            class="text-orange-500">*</span></label>
                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">
                        Min. 8 znaků, velké a malé písmeno, číslice a speciální znak.
                    </p>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-bold focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div class="mt-8 pt-4">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest hover:-translate-y-1">
                        Vytvořit účet
                    </button>
                    <p class="text-center text-slate-500 text-sm mt-6 font-medium">
                        Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                            class="text-orange-500 font-bold hover:text-orange-600 transition-colors underline decoration-orange-500/30 underline-offset-4">Přihlaste
                            se zde</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>