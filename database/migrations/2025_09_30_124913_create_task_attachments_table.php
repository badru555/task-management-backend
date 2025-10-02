<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('original_name');
            $table->string('file_name');        // nama file di storage (hashed)
            $table->string('file_path');        // storage path
            $table->string('storage_disk')->default('local'); // 'local' or 's3'
            $table->bigInteger('file_size');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->boolean('is_active')->default(true); // active version
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->index(['task_id', 'original_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_attachments');
    }
}
