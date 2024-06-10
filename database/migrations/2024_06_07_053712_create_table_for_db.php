<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
 /**
 * Run the migrations.
*
 * @return void
 */
 public function up()
 {
 Schema::create('users', function (Blueprint $table) {
 $table->id();
 $table->string('name');
 $table->enum('role', ['admin', 'guru', 'siswa']);
 $table->string('email')->unique();
 $table->timestamp('email_verified_at')->nullable();
 $table->string('password');
 $table->rememberToken();
 $table->timestamps();
 });

 Schema::create('guru', function (Blueprint $table) {
 $table->id();
 $table ->string('nama_guru');
 $table->date('tgl_lahir');
 $table->string('alamat');
 $table->string('no_telp');
 $table->timestamps();
 $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('jadwal', function (Blueprint $table) {
 $table->string('id _jadwal');
 $table->string('kode_mapel');
 $table->string('kode_kelas');
 $table->integer('id_guru');
 $table->string('hari');
 $table->time('jam_mulai');
 $table->time('jam_akhir');

 $table->primary('id_jadwal');
 $table->foreign('kode_mapel')->references('kode_mapel ')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('mapel', function (Blueprint $table) {
 $table->id();
 $table->integer('id_guru');
 $table->string('nama_mapel');
 $table->timestamps(); 

$table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('materi', function (Blueprint $table) {
 $table->id();
 $table->integer('kode_mapel');
 $table->string('judul_materi');
 $table->text('deskripsi');
 $table->string('file');
 $table->timestamps();
 $table->integer('kode_kelas');
 $table->integer('tahun_id')->nullable();

 $table ->foreign('kode_mapel')->references('kode_mapel')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('tahun_id')->references('id_ajar')->on('tahun_ajar')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('siswa', function (Blueprint $table) {
 $table->id();
 $table->string('nama_siswa');
 $table-> date('tgl_lahir');
 $table->string('alamat');
 $table->string('no_telp');
 $table->integer('user_id');
 $table->timestamps();
 $table->string('kode_kelas');

 $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('tahun_ajar', function (Blueprint $table) {
 $table->id();
 $table->string('tahun_ajaran');
 $table->enum('semester', ['Ganjil', 'Genap']);
 $table->enum('status', ['Berlangsung', 'Berakhir', 'Belum Terlaksana']);
 $table->timestamps();
 });

 Schema::create('tb_admin', function (Blueprint $table) {
 $table->id();
 $table->integer('user_id');
 $table->string('nama_admin');
 $table->date('tgl_lahir');
 $table->string('alamat');
 $table->string('no_telp');
 $table->timestamps();

 $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('tugas', function (Blueprint $table) {
 $table->id();
 $table->integer('kode_mapel');
 $table->integer('kode_kelas')->nullable();
 $table->string('nama_tugas');
 $table->text('deskripsi');
 $table-> string('file');
 $table->datetime('deadline')->nullable();
 $table->timestamps();
 $table->integer('tahun_id')->nullable();

 $table->foreign('kode_mapel')->references('kode_mapel')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('tahun_id')->references('id_ajar')->on('tahun_ajar')->onDelete('cascade')->onUpdate('cascade');
 });

 Schema::create('jawaban', function (Blueprint $table) {
 $table->id();
 $table->integer('id_siswa');
 $table->integer('kode_tugas');
 $table->string('file');
 $table->timestamps();

 $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
 $table->foreign('kode_tugas')->references('kode_tugas')->on('tugas')->onDelete('cascade')->onUpdate('cascade');
 });
 }

 /**
 * Reverse the migrations.
*
 * @return void
 */
 public function down()
 {
 Schema::dropIfExists('jawaban');
 Schema::dropIfExists('tugas');
 Schema::dropIfExists('tb_admin');
 Schema::dropIfExists('tahun_ajar');
 Schema::dropIfExists('siswa');
 Schema::dropIfExists('materi');
 Schema::dropIfExists('mapel');
 Schema::dropIfExists('jadwal');
 Schema::dropIfExists('guru');
 Schema::dropIfExists('users');
 }
}
