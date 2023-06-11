<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function(Blueprint $table) {
            $table->foreignId('created_by');

            // We might want to cascade on delete. It all depends on how we want to handle deletes.
            // Usually I like to start of using "restrict", since it easier to switch to cascade later on when you
            // hit the foreign key, than restoring data that has been lost because we used "cascade" "accidentally"
            //
            // Also, if this was a change to a production system, we would need a way to migrate old database rows.
            // This change now requires a fresh DB migration.
            // A solution would be to split this migration up into a few different migrations like:
            //     1. Add the `created_by` column.
            //     2. Update existing client rows so that get a user (maybe some sort of admin/root user)
            //     3. Add the foreign key.
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::table('clients', function(Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
