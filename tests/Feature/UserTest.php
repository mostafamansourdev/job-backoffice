<?php

use App\Models\User;


test('Create user that will pass', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
        'role' => 'job-seeker',
    ];

    $user = User::Create($data);
    expect($user->name)->toBe($data['name']);
    expect($user->email)->toBe($data['email']);
    expect($user->role)->toBe($data['role']);
});

test('create user that will fail test', function () {
    $data = [
        'name' => '',
        'email' => 'john@example.com',
    ];

    try {
        $user = User::Create($data);
        $failed = false;
    } catch (\Exception $e) {
        $failed = true;
    }

    expect($failed)->toBeTrue();
    expect(User::Where('email', 'john@example.com')->exists())->toBeFalse();
});
