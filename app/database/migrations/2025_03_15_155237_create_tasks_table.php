<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();

			$table->foreignIdFor(User::class)
				->constrained()
				->cascadeOnUpdate()
				->cascadeOnDelete();

			$table->foreignIdFor(Project::class)
				->constrained()
				->cascadeOnUpdate()
				->cascadeOnDelete();

			$table->string('title', 500);
			$table->enum('status', ['complete', 'incomplete'])->default('incomplete');
			$table->enum('priority', ['low', 'medium', 'high'])->default('low');
			$table->longText('description')->nullable();
			$table->date('due_date');
			$table->date('deadline');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tasks');
	}
};
