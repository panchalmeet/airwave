<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_master', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->smallInteger('status')->default(1)
                ->comment('1 => Active 0 => Inactive');
            $table->bigInteger('created_by')->nullable()
                ->comment('User id who has created this record. ');
            $table->bigInteger('update_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_master');
    }
};
