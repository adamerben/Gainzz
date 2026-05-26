<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-lg">
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-black tracking-widest text-slate-900 uppercase italic">Vítejte <span
                    class="text-orange-500">zpět</span></h2>
            <p class="text-slate-500 font-medium mt-2">Přihlaste se do svého účtu GAINZZZ.</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl shadow-xl p-8 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="space-y-6">

                <div>
                    <label for="email"
                        class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">E-mail</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-bold focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label for="password"
                        class="block text-xs font-black text-slate-500 mb-2 uppercase tracking-widest">Heslo</label>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-bold focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div class="mt-8 pt-4">
                    <button type="submit"
                        class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest hover:-translate-y-1">
                        Přihlásit se
                    </button>
                    <p class="text-center text-slate-500 text-sm mt-6 font-medium">
                        Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register"
                            class="text-orange-500 font-bold hover:text-orange-600 transition-colors underline decoration-orange-500/30 underline-offset-4">Zaregistrujte
                            se</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>