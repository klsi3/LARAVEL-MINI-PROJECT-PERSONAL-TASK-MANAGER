<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();                                    // id: Task ID
            $table->string('task_name');                     // task_name: Name of the task
            $table->text('description')->nullable();         // description: Task details
            $table->string('status')->default('Pending');    // status: Pending / Completed
            $table->date('due_date');                        // due_date: Task deadline
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};