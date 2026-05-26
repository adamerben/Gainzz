<!DOCTYPE html>
<html lang="cs" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>GAINZZZ - Databáze cviků</title>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen font-sans flex flex-col">

    <header class="bg-slate-900 border-b-4 border-orange-500 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">

            <a href="<?= BASE_URL ?>/index.php" class="flex items-center hover:opacity-80 transition-opacity">
                <img src="<?= BASE_URL ?>/logo.png" alt="GAINZZZ Logo" class="h-14">
            </a>

            <nav>
                <ul class="flex items-center space-x-6">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php"
                            class="text-slate-300 hover:text-orange-400 transition-colors font-bold uppercase tracking-wider text-sm">Katalog
                            cviků</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li>
                                <a href="<?= BASE_URL ?>/index.php?url=exercise/create"
                                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-5 py-2 rounded-md transition-all shadow-md">
                                    + Přidat cvik
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/index.php?url=user/index"
                                    class="text-slate-300 hover:text-orange-400 transition-colors font-bold uppercase tracking-wider text-sm ml-4">
                                    Správa uživatelů
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="text-slate-400 text-sm border-l border-slate-700 pl-6 ml-2">
                            Ahoj, <a href="<?= BASE_URL ?>/index.php?url=user/profile"
                                class="text-white font-semibold tracking-wide hover:text-orange-500 transition-colors underline decoration-orange-500/50 underline-offset-4"><?= htmlspecialchars($_SESSION['user_name']) ?></a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout"
                                class="text-rose-400 hover:text-rose-300 transition-colors text-sm uppercase tracking-wider font-bold">
                                Odhlásit
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                                class="text-slate-300 hover:text-orange-400 transition-colors font-bold uppercase tracking-wider text-sm">Přihlásit</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register"
                                class="bg-slate-700 hover:bg-slate-600 text-white font-bold px-5 py-2 rounded-md transition-all">
                                Registrace
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-6 pt-8">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3 mb-6">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php
                    $styles = [
                        'success' => 'bg-emerald-100 border-emerald-500 text-emerald-800',
                        'error' => 'bg-rose-100 border-rose-500 text-rose-800',
                        'notice' => 'bg-orange-100 border-orange-500 text-orange-800',
                    ];
                    $style = $styles[$type] ?? 'bg-slate-200 border-slate-500 text-slate-800';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $style ?> border-l-4 p-4 rounded-r-lg shadow-sm">
                            <p class="font-bold text-sm"><?= htmlspecialchars($message) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
    </div>