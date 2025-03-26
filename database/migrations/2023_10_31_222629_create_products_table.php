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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique('product_uuid_unique');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('sub_category_id')->unsigned();
            $table->string('name', 255);
            $table->string('part_number', 255);
            $table->string('outer_td', 100)->nullable();
            $table->string('outer_bd', 100)->nullable();
            $table->string('inner_td', 100)->nullable();
            $table->string('inner_bd', 100)->nullable();
            $table->string('no_check_valve', 100)->nullable();
            $table->string('no_pass_valves', 100)->nullable();
            $table->string('thread', 100)->nullable();
            $table->string('height', 50)->nullable();
            $table->string('main_img', 255);
            $table->string('sec_img', 255);
            $table->string('thrd_img', 255);
            $table->string('price', 20);
            $table->smallInteger('status')
                    ->default(1)
                    ->comment('1 => Active 0 => Inactive');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(['category_id'], 'categor_id_fk')
                ->references(['id'])
                ->on('categories')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');

            $table->foreign(['sub_category_id'], 'sub_category_id_fk')
                ->references(['id'])
                ->on('sub_categories')
                ->onUpdate('CASCADE')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
