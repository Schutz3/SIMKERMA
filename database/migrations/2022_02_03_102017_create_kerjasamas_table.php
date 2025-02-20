<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKerjasamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->string("mitra")->nullable();
            $table->string("kerjasama");
            $table->date("tanggal_mulai")->nullable();
            $table->date("tanggal_selesai")->nullable();
            $table->string("nomor")->nullable();
            $table->text("kegiatan")->nullable();
            $table->string("bidang_kerjasama_id");
            $table->string("kriteria_mitra_id");
            $table->string("kriteria_kemitraan_id");
            $table->string("sifat");
            $table->string("pks");
            $table->string("jurusan");
            $table->string("prodi")->nullable();
            $table->string("pic_pnj");
            $table->text("alamat_perusahaan");
            $table->string("pic_industri");
            $table->string("jabatan_pic_industri")->nullable();
            $table->string("telp_industri");
            $table->string("email");
            $table->text("file");
            $table->integer("step")->default(1);
            $table->integer("user_id")->default(1);
            $table->text("catatan")->nullable();
            $table->integer("reviewer_id")->nullable();
            $table->string("target_reviewer_id")->nullable();
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
        Schema::dropIfExists('kerjasamas');
    }
}
