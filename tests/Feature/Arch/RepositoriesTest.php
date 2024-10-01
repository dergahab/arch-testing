<?php

use Illuminate\Support\Facades\File;

it('ensures all repository files have the Repository suffix', function () {
    $repositoryBasePath = base_path('app/Repositories');

    $files = File::allFiles($repositoryBasePath);

    foreach ($files as $file) {
        $filename = $file->getFilename();

        expect($filename)
            ->toEndWith('Repository.php', "The file '{$filename}' does not have the 'Repository' suffix.");
    }
});

it('ensures all repository classes have the correct class name and suffix', function () {
    $serviceBasePath = base_path('app/Repositories');

    $files = File::allFiles($serviceBasePath);

    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Repositories\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            expect($className)
                ->toEndWith('Repository', "The class '{$className}' does not have the 'Repository' suffix.");
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
});
