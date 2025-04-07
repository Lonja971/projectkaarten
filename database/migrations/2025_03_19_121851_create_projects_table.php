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
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->boolean('filled')->nullable();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->string('reflection')->nullable();
            $table->integer('rating')->nullable();
            $table->string('feedback')->nullable();
            $table->string('denial_reason')->nullable();
            $table->foreignId('status_id')->default(env('DEFAULT_PROJECT_STATUS_ID'))->constrained('project_statuses')->onDelete('cascade');
            $table->integer('icon_id')->default(env('DEFAULT_PROJECT_ICON_ID'));
            $table->integer('background_id')->default(env('DEFAULT_PROJECT_BACKGROUND_ID'));
            $table->integer('project_by_student');
            $table->timestamps();
        });

        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
        });

        Schema::create('backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('background_color');
        });

        Schema::create('project_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('project_workprocesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_goal_id')->constrained('project_goals')->onDelete('cascade');
            $table->foreignId('workprocess_id')->constrained('workprocesses')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_workprocesses');
        Schema::dropIfExists('project_goals');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_statuses');
    }
};
