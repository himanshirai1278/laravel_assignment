<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('web_push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscribable_id');
            $table->string('subscribable_type');
            $table->text('endpoint')->unique();
            $table->string('public_key');
            $table->string('auth_token');
            $table->timestamps();
            $table->index(['subscribable_id','subscribable_type']);
        });
    }
    public function down(): void { Schema::dropIfExists('web_push_subscriptions'); }
};