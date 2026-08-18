<?php

use App\Models\Product;

it('switches locale and persists it in the session', function () {
    $response = $this->get(route('language.switch', ['locale' => 'ar']));

    $response->assertRedirect();
    expect(session('locale'))->toBe('ar');
    expect(app()->getLocale())->toBe('ar');
});

it('uses translated product names based on the active locale', function () {
    $product = new Product([
        'name_en' => 'iPhone 15',
        'name_ar' => 'آيفون 15',
        'desc_en' => 'Premium smartphone',
        'desc_ar' => 'هاتف ذكي فاخر',
    ]);

    app()->setLocale('en');
    expect($product->name)->toBe('iPhone 15');
    expect($product->description)->toBe('Premium smartphone');

    app()->setLocale('ar');
    expect($product->name)->toBe('آيفون 15');
    expect($product->description)->toBe('هاتف ذكي فاخر');
});
