<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$users = \App\Models\User::all();
$categories = \App\Models\Category::all();
$events = \App\Models\Event::all();
$transactions = \App\Models\Transaction::all();

echo "=== Database Verification ===\n";
echo "Users: " . $users->count() . "\n";
echo "Categories: " . $categories->count() . "\n";
echo "Events: " . $events->count() . "\n";
echo "Transactions: " . $transactions->count() . "\n";
echo "\n=== Users ===\n";
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - Role: {$user->role}\n";
}
echo "\n=== Categories ===\n";
foreach ($categories as $category) {
    echo "- {$category->name} (Slug: {$category->slug})\n";
}
echo "\n=== Events ===\n";
foreach ($events as $event) {
    $categoryName = $event->category->name;
    echo "- {$event->title} ({$categoryName}) - Price: Rp {$event->price} - Stock: {$event->stock}\n";
}
