<?php

use App\Models\User;
use App\Models\Coupon;
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
        
        Schema::create('coupon_useds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->onupdateCascade()->onDeleteCascade();
            $table->foreignIdFor(Coupon::class)->onupdateCascade()->onDeleteCascade();
            $table->string('coupon_code')->nullable();
            $table->double('amount', 12, 2)->default(0);
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
        Schema::dropIfExists('coupon_useds');
    }
};
