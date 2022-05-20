<?php

use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid('product_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('quantity')->default(1);
            $table->boolean('status')->default(0);
            $table->boolean('completed')->default(0);
            $table->foreignIdFor(Vendor::class)->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('carts');
    }
};
