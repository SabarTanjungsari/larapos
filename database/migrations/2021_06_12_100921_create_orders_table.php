<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('dateordered');
            $table->string('invoice')->unique();
            $table->bigInteger('partner_id')->unsigned();
            $table->bigInteger('createdby')->unsigned();
            $table->double('grandtotal');
            $table->enum('docstatus', ['DR', 'CO', 'CL'])->default('DR');
            $table->boolean('issotrx')->default(true);
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            //$table->foreign('createdby')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
