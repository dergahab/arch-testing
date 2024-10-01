<?php

arch('services')
    ->expect('App\Services')
    ->toOnlyBeUsedIn('App\Http\Controllers')
    ->ignoring([
        'App\Services\BaseService',
        'App\Services'
    ]);

arch('repositories')
    ->expect('App\Repositories')
    ->toOnlyBeUsedIn('App\Services')
    ->ignoring([
        'App\Repositories\BaseRepository',
        'App\Repositories'
        ]);


arch('models expect')
    ->expect('App\Models')
    ->toOnlyBeUsedIn('App\Repositories')
    ->ignoring([
        'App\Http\Middleware',
        'App\Http\Requests',
        'App\Models\BaseModel',
        'App\Services',
        'App\Models'
    ]);


test('globals')
    ->expect(['dd', 'ddd', 'die', 'dump', 'ray', 'sleep', 'eval', 'print_r', 'var_dump'])
    ->toBeUsedInNothing();


