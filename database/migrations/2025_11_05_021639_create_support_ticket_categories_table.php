<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_ticket_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->datetimes();
        });

        Schema::create('support_ticket_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('support_ticket_category_id')
                ->index('support_ticket_category_translations_id_index')
                ->constrained('support_ticket_categories', 'id', 'support_ticket_category_translations_foreign')
                ->onDelete('cascade');
            $table->string('locale', 5)->index();
            $table->string('name');
            $table->unique(['support_ticket_category_id', 'locale'], 'support_ticket_category_translations_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_ticket_category_translations');
        Schema::dropIfExists('support_ticket_categories');
    }
};
