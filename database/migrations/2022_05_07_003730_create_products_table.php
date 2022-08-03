<?php

use App\Models\Vendor;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ParentSubCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->string('brand', 50);
            $table->longText('description');
            $table->foreignIdFor(ProductCategory::class)->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(ParentCategory::class)->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(ParentSubCategory::class)->onUpdate('cascade')->onDelete('cascade');
            $table->double('retail_price', 12,2)->default(0);
            $table->float('markup_percentage')->default(0);
            $table->double('price', 12,2)->default(0);
            $table->foreignIdFor(Vendor::class)->onUpdate('cascade')->onDelete('cascade');
            $table->longText('gift_shops');
            $table->longText('colors');
            $table->string('dimension')->nullable();
            $table->boolean('is_discounted')->default(0);
            $table->float('discount_percentage')->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->boolean('limited_stock')->default(0);
            $table->string('sku')->nullable();
            $table->longText('images')->nullable();
            $table->longText('main_image')->nullable();
            $table->boolean('visibility')->default(1);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
