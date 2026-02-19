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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer'])
                ->after('total');

            $table->integer('cash_amount')
                ->nullable()
                ->after('payment_method');

            $table->integer('change_amount')
                ->nullable()
                ->after('cash_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'cash_amount',
                'change_amount',
            ]);
        });
    }
};
