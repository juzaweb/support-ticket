<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Juzaweb\Modules\Admin\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('support_ticket_replies', 'created_by')) {
            Schema::table('support_ticket_replies', function (Blueprint $table) {
                $table->creator();
            });
        }

        if (Schema::hasColumn('support_ticket_replies', 'user_id')) {
            DB::table('support_ticket_replies')
                ->update([
                    'created_by' => DB::raw('user_id'),
                    'created_type' => User::class,
                ]);

            Schema::table('support_ticket_replies', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
