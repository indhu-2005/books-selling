<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->after('author');
            $table->foreignId('author_id')->nullable()->constrained('authors')->nullOnDelete()->after('category_id');
            $table->string('category_name')->nullable()->after('author_id');
            $table->string('condition')->default('Good')->after('price');
            $table->string('isbn')->nullable()->after('condition');
            $table->string('language')->default('English')->after('isbn');
            $table->string('publisher')->nullable()->after('language');
            $table->integer('pages')->nullable()->after('publisher');
            $table->boolean('is_exchangeable')->default(true)->after('pages');
            $table->string('exchange_type')->default('Buy / Exchange')->after('is_exchangeable');
            $table->boolean('featured')->default(false)->after('exchange_type');
            $table->decimal('rating', 3, 1)->default(4.5)->after('featured');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['author_id']);
            $table->dropColumn([
                'category_id',
                'author_id',
                'category_name',
                'condition',
                'isbn',
                'language',
                'publisher',
                'pages',
                'is_exchangeable',
                'exchange_type',
                'featured',
                'rating'
            ]);
        });
    }
};
