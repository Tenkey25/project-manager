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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('name')->after('id');    //idカラムの後に配置
            $table->string('status')->default('todo');   //nameカラムの後に
            $table->date('start_date')->nullable();   //日付（YYYY-MM-DD）形式
            $table->date('end_date')->nullable();
            $table->softDeletes();   //'deleted_at'カラムを自動追加,論理削除を有効化
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('status');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('deleted_at');
        });
    }
};
