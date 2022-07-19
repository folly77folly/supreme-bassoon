<?php

use App\Models\Admin;
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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class)->nullable()->onUpdate('cascade')->onDelete('cascade');
            $table->string('vendor_name', 50)->unique();
            $table->string('contact_name', 50)->unique();
            $table->string('phone_no', 20);
            $table->string('email')->unique();
            $table->string('store_address', 150);
            $table->string('description', 200);
            $table->boolean('is_active')->default(1);
            $table->string('slug')->unique();
            $table->double('commission_fee')->default(0);
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
        Schema::dropIfExists('vendors');
    }
};
