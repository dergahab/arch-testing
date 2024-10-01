<?php

use Illuminate\Support\Facades\File;

it('ensures all repository files have the Controller suffix', function () {
    $controllerBasePath = base_path('app/Http/Controllers');

    $files = File::allFiles($controllerBasePath);

    foreach ($files as $file) {
        $filename = $file->getFilename();
        expect($file->getFilename())->toEndWith('Controller.php', "The file '{$filename}' does not have the 'Controller' suffix.");
    }
});


it('ensures all repository classes have the correct class name and suffix', function () {
    $controllerBasePath = base_path('app/Http/Controllers');

    $files = File::allFiles($controllerBasePath);

    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Http\\Controllers\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            expect($className)
                ->toEndWith('Controller', "The class '{$className}' does not have the 'Controller' suffix.");
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
});

it('ensures all service classes extend BaseController', function () {
    $serviceBasePath = base_path('app/Http/Controllers');

    $files = File::allFiles($serviceBasePath);
    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Http\\Controllers\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            if ($className === 'App\\Http\\Controllers\\BaseController') {
                continue;
            }

            $reflectionClass = new ReflectionClass($className);
            $parentClass = $reflectionClass->getParentClass();

            if ($parentClass) {
                expect($parentClass->getName())
                    ->toBe('App\\Http\\Controllers\\BaseController', "The class '{$className}' does not extend 'BaseController'.");
            } else {
                throw new Exception("The class '{$className}' does not extend any class.");
            }
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
});


