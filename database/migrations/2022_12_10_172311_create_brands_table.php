<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('brands')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('brands')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->enum('status',[1,2])->default(1)->comment('1=active,2=inactive');   
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
        Schema::dropIfExists('brands');
    }
};
