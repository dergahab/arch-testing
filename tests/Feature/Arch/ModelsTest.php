<?php
use Illuminate\Support\Facades\File;

it('ensures all model files have the Model suffix', function () {
    $modelBasePath = base_path('app/Models');

    $files = File::allFiles($modelBasePath);

    foreach ($files as $file) {
        $filename = $file->getFilename();
        expect($file->getFilename())->toEndWith('Model.php', "The file '{$filename}' does not have the 'Model' suffix.");
    }
})->skip('DTBExplorationType ');


it('ensures all model classes have the correct class name and suffix', function () {
    $modelBasePath = base_path('app/Models');

    $files = File::allFiles($modelBasePath);

    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Models\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            expect($className)
                ->toEndWith('Model', "The class '{$className}' does not have the 'Model' suffix.");
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
})->skip();

it('ensures all model classes extend BaseModel', function () {
    $modelBasePath = base_path('app/Models');

    $files = File::allFiles($modelBasePath);
    foreach ($files as $file) {
        $relativePath = $file->getRelativePathname();

        $className = 'App\\Models\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

        if (class_exists($className)) {
            if ($className === 'App\\Models\\BaseModel') {
                continue;
            }

            $reflectionClass = new ReflectionClass($className);
            $parentClass = $reflectionClass->getParentClass();

            if ($parentClass) {
                expect($parentClass->getName())
                    ->toBe('App\\Models\\BaseModel', "The class '{$className}' does not extend 'BaseModel'.");
            } else {
                throw new Exception("The class '{$className}' does not extend any class.");
            }
        } else {
            throw new Exception("The class '{$className}' does not exist for the file '{$file->getFilename()}'.");
        }
    }
})->skip();

