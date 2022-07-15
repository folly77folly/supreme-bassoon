<?php

use App\Models\OrderStatus;
use App\Models\DeliveryStatus;
use Illuminate\Support\Facades\Schema;
use App\Models\{Order, Product, Vendor};
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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(Product::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(Vendor::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(DeliveryStatus::class)->default(1)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(OrderStatus::class)->default(1)->onUpdateCascade()->onDeleteCascade();
            $table->double('unit_price')->unsigned()->default(0);
            $table->integer('quantity')->default(0)->unsigned();
            $table->double('total_amount')->default(0)->unsigned();           
            $table->double('total_discount')->default(0)->unsigned();                  
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
