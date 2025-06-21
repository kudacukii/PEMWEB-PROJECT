<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampaignSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Bantu Sarah melawan kanker",
      "category"       => "HEALTH",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/health",
      "description"    => "Sarah baru-baru ini didiagnosis kanker payudara stadium 4 dan membutuhkan bantuan untuk biaya pengobatan.",
      "targetfunding"  => 720000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Dukung perlengkapan sekolah lokal",
      "category"       => "EDUCATION",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/edu",
      "description"    => "Bantu kami menyediakan perlengkapan sekolah untuk 500 anak kurang mampu di komunitas kami.",
      "targetfunding"  => 216000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Selamatkan tempat penampungan hewan kami",
      "category"       => "PETS",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/community",
      "description"    => "Tempat penampungan hewan lokal kami berisiko ditutup. Bantu kami tetap membukanya dan selamatkan ratusan hewan.",
      "videolink"      => "https://www.youtube.com/watch?v=WG-dqzJglqo",
      "targetfunding"  => 432000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Biaya kuliah untuk anak petani",
      "category"       => "EDUCATION",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/edu2",
      "description"    => "Bantu Rizal menyelesaikan pendidikan kedokterannya. Orang tuanya petani yang kesulitan membiayai kuliah.",
      "targetfunding"  => 21600000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 2,
      "title"          => "Operasi jantung untuk Max",
      "category"       => "PETS",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/cat",
      "description"    => "Kucing kami Max membutuhkan operasi jantung darurat. Dia sudah menjadi bagian keluarga kami selama 18 tahun.",
      "videolink"      => "https://www.youtube.com/shorts/CeDBNST65_8",
      "targetfunding"  => 15000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 2,
      "title"          => "Buku cerita anak berkebutuhan khusus",
      "category"       => "CREATIVITY",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/creative",
      "description"    => "Saya ingin menerbitkan buku cerita khusus untuk anak berkebutuhan khusus dengan ilustrasi yang ramah sensorik.",
      "targetfunding"  => 18000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 2,
      "title"          => "Bantu keluarga korban kebakaran",
      "category"       => "EMERGENCY",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/fire",
      "description"    => "Keluarga Pak Joko kehilangan rumah dan seluruh harta benda dalam kebakaran semalam. Mereka membutuhkan bantuan darurat.",
      "targetfunding"  => 180000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Transplantasi hati untuk bayi 6 bulan",
      "category"       => "HEALTH",
      "location"       => "Jakarta Kota",
      "photo"          => "stocks/baby",
      "description"    => "Bayi Arumi membutuhkan transplantasi hati segera. Ayahnya yang pengojek adalah donor yang cocok, tetapi biaya operasi sangat besar.",
      "targetfunding"  => 385000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);

    DB::table('campaigns')->insert([
      "status"         => "ACTIVE",
      "owner"          => 1,
      "title"          => "Bantu korban banjir di Tenggarong",
      "category"       => "DISASTER",
      "location"       => "Tenggarong Kalimantan Timur",
      "photo"          => "stocks/flood",
      "description"    => "Ribuan orang kehilangan tempat tinggal dan harta benda akibat hujan deras tujuh hari berturut turut di Tenggarong",
      "targetfunding"  => 275000000,
      "deadline"       => "2025-06-30",
      "accounttype"    => "PERSONAL",
      "accountbank"    => "MANDIRI",
      "accountholder"  => "1234",
      "accountno"      => "1234",
      "created_at"     => Carbon::now(),
      "updated_at"     => Carbon::now()
    ]);
  }
}
