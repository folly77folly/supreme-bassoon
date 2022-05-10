<?php

use App\Models\Product;
use App\Models\GiftShop;
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
        Schema::create('product_gift_shops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(GiftShop::class)->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_gift_shops');
    }
};
