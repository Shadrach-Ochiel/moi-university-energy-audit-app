<?php
/**
 * @var $this \CodeIgniter\View\View
 */
?>
<?= $this->extend('layouts/base.layout.php') ?>

<?= $this->section('content') ?>
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-primary selection:text-white">
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        <?php if (auth()->check()): ?>
            <a href="<?= url_to('dashboard') ?>" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-2 focus:rounded-sm focus:outline-primary">Dashboard</a>
        <?php else: ?>
            <a href="<?= url_to('login') ?>" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-2 focus:rounded-sm focus:outline-primary">Log in</a>
            <a href="<?= url_to('register') ?>" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline-2 focus:rounded-sm focus:outline-primary">Register</a>
        <?php endif; ?>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-primary text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
        </div>

        <div class="mt-10 text-center">
            <h1 class="text-3xl font-semibold text-gray-800">G12 Energy Audit</h1>
            <p class="mt-4 text-lg text-gray-500">
                Run walkthroughs and ASHRAE assessments, log findings and track the savings they identify.
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
