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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique('category_uuid_unique');
            $table->bigInteger('category_id')->unsigned();
            $table->string('name', 255);
            $table->string('slug', 100)->unique();
            $table->smallInteger('status')
                    ->default(1)
                    ->comment('1 => Active 0 => Inactive');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(['category_id'], 'category_id_fk')
                ->references(['id'])
                ->on('categories')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
