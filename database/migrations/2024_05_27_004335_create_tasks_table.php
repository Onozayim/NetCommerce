<?php

use App\Models\Company;
use App\Models\User;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 100);
            $table->timestamp('start_at')->useCurrent();
            $table->timestamp('expired_at')->nullable();
            $table->boolean('is_completed')->default(0);

            $table->foreignIdFor(Company::class)
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('tasks');
    }
};
