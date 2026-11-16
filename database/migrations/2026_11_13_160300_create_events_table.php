<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('event_date');
            $table->string('event_time')->default('10:00 AM - 1:00 PM');
            $table->string('location');
            $table->string('event_type')->default('Book Exchange Meet'); // Book Exchange Meet, Author Talk, Reading Club, Book Drive
            $table->text('description');
            $table->string('speaker')->nullable();
            $table->string('image')->nullable();
            $table->string('entry_fee')->default('Free Entry');
            $table->integer('max_attendees')->default(50);
            $table->integer('attendees_count')->default(0);
            $table->timestamps();
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('books_to_exchange')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('events');
    }
};
