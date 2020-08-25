<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['mail', 'sms', 'database', 'slack']);
            $table->boolean('send_now');
            $table->enum('status', ['pending', 'sent', 'failed']);
            $table->boolean('success')->nullable();
            $table->text('content');
            $table->boolean('markdown');
            $table->text('recipients');
            $table->timestamp('send_on')->useCurrent();
            $table->timestamp('sent_on')->nullable();
            $table->foreignId('token_id')->constrained('tokens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
