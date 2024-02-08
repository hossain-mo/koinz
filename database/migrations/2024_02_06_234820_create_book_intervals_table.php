<?php

use App\Models\Book;
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
        Schema::create('book_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class);
            $table->integer('num_of_read_pages');
            $table->string('intervals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_intervals');
    }
};
