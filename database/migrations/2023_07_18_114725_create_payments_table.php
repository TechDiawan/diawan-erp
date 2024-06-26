<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->string('method')->comment('manual, stripe, paypal etc');
            $table->enum('status', ['pending', 'cancelled', 'success', 'failed'])->default('pending');
            $table->string('system_trx_id')->unique()->comment('Transaction ID generated by this system');
            $table->string('gateway_trx_id')
                ->nullable()
                ->comment('Transaction ID generated by 3rd party payment gateway/bank/check number or any other');
            $table->string('currency')->nullable();
            $table->decimal('amount', 16, 2);
            $table->json('data')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
