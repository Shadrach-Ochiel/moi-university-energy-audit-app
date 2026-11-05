<?php
/**
 * @var $this \CodeIgniter\View\View
 */
?>
<?= $this->extend('layouts/base.layout.php') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="<?= url_to('/') ?>" class="flex items-center space-x-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                </svg>
                            </span>
                            <span class="text-sm font-semibold tracking-tight text-gray-900">G12 Energy Audit</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="<?= url_to('dashboard') ?>" class="inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-primary transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                    </div>
                </div>

                <!-- Settings Dropdown / Auth Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <?php if (auth()->check()): ?>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700"><?= auth()->user()->username ?? 'User' ?></span>
                            <form action="<?= url_to('logout') ?>" method="post">
                                 <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                                </form>
                           
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <a href="<?= url_to('login') ?>" class="text-sm text-gray-700 underline">Log in</a>
                            <a href="<?= url_to('register') ?>" class="text-sm text-gray-700 underline">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    <?php if (isset($header)): ?>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <?= $header ?>
            </div>
        </header>
    <?php endif; ?>

    <!-- Page Content -->
    <main>
        <?= $this->renderSection('main') ?>
    </main>
</div>
<?= $this->endSection() ?>
