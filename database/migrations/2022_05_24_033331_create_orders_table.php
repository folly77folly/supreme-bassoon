<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{User, ChildrenProfile, AddressBook, PaymentMethod, DeliveryStatus,OrderStatus};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(ChildrenProfile::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(AddressBook::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(PaymentMethod::class)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(DeliveryStatus::class)->default(1)->onUpdateCascade()->onDeleteCascade();
            $table->foreignIdFor(OrderStatus::class)->default(1)->onUpdateCascade()->onDeleteCascade();
            $table->double('total_price')->unsigned()->default(0);
            $table->double('shipping_price')->unsigned()->default(0);
            $table->string('trans_id');
            $table->string('reference');
            $table->double('discount')->unsigned()->default(0);
            $table->string('delivery_days');       
            $table->boolean('paid')->default(0);  
            $table->boolean('approved')->default(0);
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
        Schema::dropIfExists('orders');
    }
};
