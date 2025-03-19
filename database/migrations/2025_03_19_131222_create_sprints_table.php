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
        Schema::create('sprint_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->integer('week_nr');
            $table->string('reflection')->nullable();
            $table->string('feedback')->nullable();
            $table->foreignId('status_id')->constrained('sprint_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sprint_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained('sprints')->onDelete('cascade');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('sprint_core_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_goal_id')->constrained('sprint_goals')->onDelete('cascade');
            $table->foreignId('core_task_id')->constrained('core_tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprint_core_tasks');
        Schema::dropIfExists('sprint_goals');
        Schema::dropIfExists('sprints');
        Schema::dropIfExists('sprint_statuses');
    }
};
