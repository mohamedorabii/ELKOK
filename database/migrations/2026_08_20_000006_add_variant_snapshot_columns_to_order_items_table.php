<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')
                ->nullable()
                ->after('product_id')
                ->constrained('product_variants')
                ->nullOnDelete();
            $table->string('color_name_en')->nullable()->after('total_price');
            $table->string('color_name_ar')->nullable()->after('color_name_en');
            $table->string('size_name_en')->nullable()->after('color_name_ar');
            $table->string('size_name_ar')->nullable()->after('size_name_en');
            $table->string('variant_sku')->nullable()->after('size_name_ar');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_variant_id');
            $table->dropColumn([
                'color_name_en',
                'color_name_ar',
                'size_name_en',
                'size_name_ar',
                'variant_sku',
            ]);
        });
    }
};