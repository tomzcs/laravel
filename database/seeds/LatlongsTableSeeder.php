<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LatlongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('latlongs')->insert([
          'lat' => '13.7678398',
          'long' => '100.5644615',
          'name' => 'ศูนย์วัฒนธรรมแห่งประเทศไทย',
          'detail' => '14 ถนน เทียมร่วมมิตร แขวง ห้วยขวาง เขต ห้วยขวาง กรุงเทพมหานคร 10310',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);

      DB::table('latlongs')->insert([
          'lat' => '13.7563521',
          'long' => '100.565554',
          'name' => 'โรงพยาบาลพระรามเก้า',
          'detail' => '99 ถนนพระราม 9 แขวงบางกะปิ เขต ห้วยขวาง กรุงเทพมหานคร 10310',
          'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
          'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
      ]);
    }
}
