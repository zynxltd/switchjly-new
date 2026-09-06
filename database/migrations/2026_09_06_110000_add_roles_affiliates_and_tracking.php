<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('affiliate')->after('password');
            $table->string('referral_code', 32)->nullable()->unique()->after('role');
            $table->decimal('commission_rate', 8, 2)->default(30)->after('referral_code');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('affiliate_id')->nullable()->after('source')->constrained('users')->nullOnDelete();
            $table->string('referral_code', 32)->nullable()->after('affiliate_id');
        });

        Schema::create('affiliate_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->cascadeOnDelete();
            $table->string('referral_code', 32);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('landing_path', 255)->nullable();
            $table->timestamps();

            $table->index(['affiliate_id', 'created_at']);
        });

        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('status', 20)->default('pending');
            $table->string('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_payouts');
        Schema::dropIfExists('affiliate_clicks');

        Schema::table('leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('affiliate_id');
            $table->dropColumn('referral_code');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'referral_code', 'commission_rate']);
        });
    }
};
