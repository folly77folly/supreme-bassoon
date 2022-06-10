<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Coupon_type;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->unique();
            $table->string('coupon_description');
            $table->foreignIdFor(Coupon_type::class)->onDelete('cascade')->onUpdate('cascade');
            $table->double('min_amount', 12,2)->default(0);
            $table->integer('usage_limit')->default(0);
            $table->longtext('emails_to_enjoy');
            $table->boolean('active');
            $table->datetime('start_date');
            $table->datetime('end_date');
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
        Schema::dropIfExists('coupons');
    }
};
