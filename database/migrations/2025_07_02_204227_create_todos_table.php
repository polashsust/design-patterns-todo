<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('due_date');
            $table->enum('status', ['offen', 'erledigt'])->default('offen');
            $table->string('category_type', 50); // WorkTask, PersonalTask, ShoppingTask
            $table->json('extra_data')->nullable(); // For extra fields (priority, mood, estimated_costs)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('todos');
    }
};
