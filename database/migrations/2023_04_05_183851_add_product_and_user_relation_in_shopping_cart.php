<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductAndUserRelationInShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopping_cart', function (Blueprint $table) {
            $table->dropForeign(['product_id', 'user_id']);
            $table->dropColumn('product_id');
            $table->dropColumn('user_id');
        });
    }
}
