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
            $table->string('color')->nullable();
            $table->boolean('filled')->nullable();
        });

        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->integer('week_nr');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->string('reflection')->nullable();
            $table->string('feedback')->nullable();
            $table->foreignId('status_id')->default(env('DEFAULT_SPRINT_STATUS_ID'))->constrained('sprint_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sprint_goals_and_retrospectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained('sprints')->onDelete('cascade');
            $table->string('description');
            $table->boolean('is_retrospective')->default(false);
            $table->timestamps();
        });
        
        Schema::create('sprint_workprocesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_goal_id')->constrained('sprint_goals_and_retrospectives')->onDelete('cascade');
            $table->foreignId('workprocess_id')->constrained('workprocesses')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprint_workprocesses');
        Schema::dropIfExists('sprint_goals_and_retrospectives');
        Schema::dropIfExists('sprints');
        Schema::dropIfExists('sprint_statuses');
    }
};
