<?php

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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('project_id')
                ->constrained() //REFERENCES projects(id)
                ->cascadeOnDelete();    //親テーブルのレコードが削除されたときに、そのレコードを参照している子テーブルの関連レコードも自動的に連鎖して削除
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('todo');
            $table->foreignId('assigned_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->softDeletes();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 外部キー制約を先に落とす（環境によって必要）
            $table->dropForeign(['project_id']);
            $table->dropForeign(['assigned_user_id']);
            
            $table->dropColumn('project_id');
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('status');
            $table->dropColumn('assigned_user_id');
            $table->dropColumn('due_date');
            $table->dropColumn('deleted_at');
        });
    }
};
