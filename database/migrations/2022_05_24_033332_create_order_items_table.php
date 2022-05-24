<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Order, Product, Vendor};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(Product::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(Vendor::class)->onUpdateCascade()->onDeleteCascade();
            $table->double('unit_price')->unsigned()->default(0);
            $table->integer('quantity')->default(0)->unsigned();
            $table->double('sub_total')->unsigned();           
            $table->boolean('paid')->default(0);             
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
        Schema::dropIfExists('order_items');
    }
};
