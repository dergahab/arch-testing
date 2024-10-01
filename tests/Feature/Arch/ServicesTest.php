<?php

use Illuminate\Support\Facades\File;

it('ensures all repository files have the Service suffix', function () {
    $serviceBasePath = base_path('app/Services');

    $files = File::allFiles($serviceBasePath);

    foreach ($files as $file) {
        $filename = $file->getFilename();
        expect($file->getFilename())->toEndWith('Service.php', "The file '{$filename}' does not have the 'Service' suffix.");
    }
});

it('ensures all repository classes have the correct class name and suffix', function () {
    $serviceBasePath = base_path('app/Services');

    $files = File::allFiles($serviceBasePath);

    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Services\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);


        if (class_exists($className)) {
            expect($className)
                ->toEndWith('Service', "The class '{$className}' does not have the 'Service' suffix.");
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
});

it('ensures all service classes extend BaseService', function () {
    $serviceBasePath = base_path('app/Services');

    $files = File::allFiles($serviceBasePath);
    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Services\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            if ($className === 'App\\Services\\BaseService' || $className === 'App\\Services\\Auth\\JWTService') {
                continue;
            }

            $reflectionClass = new ReflectionClass($className);
            $parentClass = $reflectionClass->getParentClass();

            // Ensure the class extends BaseService
            if ($parentClass) {
                expect($parentClass->getName())
                    ->toBe('App\\Services\\BaseService', "The class '{$className}' does not extend 'BaseService'.");
            } else {
                throw new Exception("The class '{$className}' does not extend any class.");
            }
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
});
