<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verifikasi UUID ===\n\n";

// Cek Categories
echo "Categories:\n";
$categories = App\Models\Category::take(3)->get();
foreach ($categories as $cat) {
    echo "  - ID: {$cat->id} | Name: {$cat->name} | Length: " . strlen($cat->id) . "\n";
}

echo "\nProducts:\n";
$products = App\Models\Product::take(3)->get();
foreach ($products as $prod) {
    echo "  - ID: {$prod->id} | Name: {$prod->name} | Length: " . strlen($prod->id) . "\n";
    if ($prod->category) {
        echo "    Category: {$prod->category->name} (ID: {$prod->category_id})\n";
    }
}

echo "\n=== UUID Verification Complete ===\n";
