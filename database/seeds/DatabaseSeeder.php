<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



       Eloquent::unguard();
       
       DB::table('regions')->delete();
       DB::table('languages')->delete();
       DB::table('users')->delete();
       DB::table('yt_questionstatuses')->delete();
       DB::table('yt_questions')->delete();
       DB::table('yt_themetypes')->delete();
       DB::table('yt_categorystatuses')->delete();
       DB::table('yt_answers')->delete();
       DB::table('products')->delete();

     
   
/*
       DB::table('users')->insert([
            'username'=>'gsarmiento',
            'name' => 'Guillermo Sarmiento',
            'gender' => 'M',
            'email' => 'webuser@gmail.com',
            'password' => Hash::make('1234')
       ]); 

*/
       DB::table('user_rols')->insert([
            'ext_id'=> 'sysadmin',
            'name'  => 'Admin'
       ]); 

       DB::table('user_rols')->insert([
            'ext_id'=> 'regular',
            'name'  => 'Regular user'
       ]); 

       DB::table('user_rols')->insert([
            'ext_id'=> 'web_user',
            'name'  => 'Web user'
       ]); 


       DB::table('users')->insert([
            'username'=>'admin',
            'name' => 'admin',
            'gender' => 'M',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'rol_id' => 1
       ]); 

       DB::table('regions')->insert([
            'code' => 'na',
            'name' => 'Nortemérica',
            'active' => 1 
       ]); 


       DB::table('regions')->insert([
            'code' => 'la',
            'name' => 'América Latina',
            'active' => 1 
       ]); 


       DB::table('regions')->insert([
            'code' => 'eu',
            'name' => 'Europa',
            'active' => 1 
       ]); 


       DB::table('regions')->insert([
            'code' => 'am',
            'name' => 'Africa y Medio Oriente',
            'active' => 1 
       ]); 


       DB::table('regions')->insert([
            'code' => 'as',
            'name' => 'Asia',
            'active' => 0 
       ]); 

       DB::table('regions')->insert([
            'code' => 'oc',
            'name' => 'Oceania',
            'active' => 0 
       ]); 



       DB::table('languages')->insert([
            'code' => 'en',
            'name' => 'English',
            'active' => 1 
       ]); 


       DB::table('languages')->insert([
            'code' => 'es',
            'name' => 'Español',
            'active' => 1 
       ]); 

       DB::table('languages')->insert([
            'code' => 'fr',
            'name' => 'Fran¢ais',
            'active' => 1 
       ]); 


       DB::table('languages')->insert([
            'code' => 'pr',
            'name' => 'Portugués',
            'active' => 1 
       ]); 


        DB::table('operating_systems')->insert([
            'code' => 'AN',
            'name' => 'Android'
       ]); 

        DB::table('operating_systems')->insert([
            'code' => 'WP',
            'name' => 'Windows Phone'
       ]); 

        DB::table('operating_systems')->insert([
            'code' => 'FP',
            'name' => 'Feature Phone'
       ]);

   /*YezzTalk*/

   DB::table('yt_theme_statuses')->insert([
            'name' => 'Nuevo',
            'ext_id' => 'new'
       ]); 

       DB::table('yt_theme_statuses')->insert([
            'name' => 'Abierto',
            'ext_id' => 'open'
       ]); 

       DB::table('yt_theme_statuses')->insert([
            'name' => 'Cerrado',
            'ext_id' => 'close'
       ]); 

/*
       DB::table('yt_themes')->insert([
            'name' => 'Android',
            'ext_id' => str_random(20),
            'yt_theme_statuses_id'=> 1
       ]); 

        DB::table('yt_themes')->insert([
            'name' => 'Windows Phone',
            'ext_id' => str_random(20),
            'yt_theme_statuses_id'=> 2

       ]); 

       DB::table('yt_themes')->insert([
            'name' => 'Aplicaciones',
            'ext_id' => str_random(20),
            'yt_theme_statuses_id'=> 3

       ]); */


       DB::table('yt_categorystatuses')->insert([
            'name' => 'New',
            'ext_id' => 'new'
       ]); 


       DB::table('yt_categorystatuses')->insert([
            'ext_id' => 'open',
            'name' => 'Open'
       ]); 


       DB::table('yt_categorystatuses')->insert([
            'ext_id' => 'close',
            'name' => 'Close'
       ]); 

       DB::table('yt_categorystatuses')->insert([
            'ext_id' => 'rejected',
            'name' => 'Rejected'
       ]); 


       DB::table('yt_themetypes')->insert([
            'code' => str_random(20),
            'name' => 'Android'
       ]);


       DB::table('yt_themetypes')->insert([
            'code' => str_random(20),
            'name' => 'Aplicaciones'
       ]);


       DB::table('yt_themetypes')->insert([
            'code' => str_random(20),
            'name' => 'camara'
       ]);

        DB::table('highlight_types')->insert([
            'code' => str_random(20),
            'name' => 'Short'
       ]);
        DB::table('highlight_types')->insert([
            'code' => str_random(20),
            'name' => 'Medium'
       ]);

        DB::table('highlight_types')->insert([
            'code' => str_random(20),
            'name' => 'Large'
       ]);







     /*

  
        DB::table('products')->insert([
            'operating_system_id' => 1,
            'model' => 'VR3604es',
            'ext_id' => str_random(20)
       ]); 


        DB::table('products')->insert([
            'operating_system_id' => 2,
            'model' => 'Billy 057',
            'ext_id' => str_random(20)
       ]); 

        DB::table('products')->insert([
            'operating_system_id' => 1,
            'model' => 'Vergatario',
            'ext_id' => str_random(20)
       ]); 


      DB::table('specifications')->insert([
            'product_id' => 1,
            'language_id' => 2,
            'ext_id'     => str_random(20) ,
            'name' => 'VR 360 Esfera' ,
            'dimensions' => 'xsxsx' ,
            'weight' => 'asas' ,
            'chipset' => 'dede' ,
            'CPU' => str_random(20) ,
            'GPU' => str_random(20),
            'SimCard' => str_random(20),
            'GsmEdge' => str_random(20),
            'HSPA' => str_random(5) ,
            'DisplayType' => str_random(5),
            'DisplaySize' => str_random(5) ,
            'Resolution' => str_random(5),
            'Multitouch' => str_random(5),
            'RearCamera' => str_random(5),
            'FrontCamera' => str_random(5),
            'VideoRecording' => str_random(5),
            'RearCameraFeatures' => str_random(5),
            'MicroSDCS' =>str_random(5) ,
            'InternalMemory' => str_random(5) ,
            'RAM' => str_random(5),
            'WLAN' =>  str_random(5),
            'Bluetooth' => str_random(5),
            'GPS' => str_random(5),
            'USB' => str_random(5),
            'BatteryType' => str_random(5),
            'BatteryCapacity' => str_random(5),
            'BatteryRemovable' => str_random(5)
         ]); 

 DB::table('specifications')->insert([
            'product_id' => 1,
            'language_id' => 1,
            'ext_id'     => str_random(20) ,
            'name' => 'VR 360 Sphere' ,
            'dimensions' => 'xsxsx' ,
            'weight' => 'asas' ,
            'chipset' => 'dede' ,
            'CPU' => str_random(20) ,
            'GPU' => str_random(20),
            'SimCard' => str_random(20),
            'GsmEdge' => str_random(20),
            'HSPA' => str_random(5) ,
            'DisplayType' => str_random(5),
            'DisplaySize' => str_random(5) ,
            'Resolution' => str_random(5),
            'Multitouch' => str_random(5),
            'RearCamera' => str_random(5),
            'FrontCamera' => str_random(5),
            'VideoRecording' => str_random(5),
            'RearCameraFeatures' => str_random(5),
            'MicroSDCS' =>str_random(5) ,
            'InternalMemory' => str_random(5) ,
            'RAM' => str_random(5),
            'WLAN' =>  str_random(5),
            'Bluetooth' => str_random(5),
            'GPS' => str_random(5),
            'USB' => str_random(5),
            'BatteryType' => str_random(5),
            'BatteryCapacity' => str_random(5),
            'BatteryRemovable' => str_random(5)
         ]); 
  DB::table('specifications')->insert([
            'product_id' => 3,
            'ext_id'     => str_random(20) ,
            'language_id' => 2,
            'name' => 'Vergatario De Lujo' ,
            'dimensions' => 'xsxsx' ,
            'weight' => 'asas' ,
            'chipset' => 'dede' ,
            'CPU' => str_random(20) ,
            'GPU' => str_random(20),
            'SimCard' => str_random(20),
            'GsmEdge' => str_random(20),
            'HSPA' => str_random(5) ,
            'DisplayType' => str_random(5),
            'DisplaySize' => str_random(5) ,
            'Resolution' => str_random(5),
            'Multitouch' => str_random(5),
            'RearCamera' => str_random(5),
            'FrontCamera' => str_random(5),
            'VideoRecording' => str_random(5),
            'RearCameraFeatures' => str_random(5),
            'MicroSDCS' =>str_random(5) ,
            'InternalMemory' => str_random(5) ,
            'RAM' => str_random(5),
            'WLAN' =>  str_random(5),
            'Bluetooth' => str_random(5),
            'GPS' => str_random(5),
            'USB' => str_random(5),
            'BatteryType' => str_random(5),
            'BatteryCapacity' => str_random(5),
            'BatteryRemovable' => str_random(5)
         ]); 

  DB::table('specifications')->insert([
            'product_id' => 3,
            'language_id' => 1,
            'ext_id'     => str_random(20) ,
            'name' => 'Killer Deluxe' ,
            'dimensions' => 'xsxsx' ,
            'weight' => 'asas' ,
            'chipset' => 'dede' ,
            'CPU' => str_random(20) ,
            'GPU' => str_random(20),
            'SimCard' => str_random(20),
            'GsmEdge' => str_random(20),
            'HSPA' => str_random(5) ,
            'DisplayType' => str_random(5),
            'DisplaySize' => str_random(5) ,
            'Resolution' => str_random(5),
            'Multitouch' => str_random(5),
            'RearCamera' => str_random(5),
            'FrontCamera' => str_random(5),
            'VideoRecording' => str_random(5),
            'RearCameraFeatures' => str_random(5),
            'MicroSDCS' =>str_random(5) ,
            'InternalMemory' => str_random(5) ,
            'RAM' => str_random(5),
            'WLAN' =>  str_random(5),
            'Bluetooth' => str_random(5),
            'GPS' => str_random(5),
            'USB' => str_random(5),
            'BatteryType' => str_random(5),
            'BatteryCapacity' => str_random(5),
            'BatteryRemovable' => str_random(5)
         ]); 

  DB::table('specifications')->insert([
            'product_id' => 2,
            'ext_id'     => str_random(20) ,
            'language_id' => 1,
            'name' => 'Billy' ,
            'dimensions' => 'xsxsx' ,
            'weight' => 'asas' ,
            'chipset' => 'dede' ,
            'CPU' => str_random(20) ,
            'GPU' => str_random(20),
            'SimCard' => str_random(20),
            'GsmEdge' => str_random(20),
            'HSPA' => str_random(5) ,
            'DisplayType' => str_random(5),
            'DisplaySize' => str_random(5) ,
            'Resolution' => str_random(5),
            'Multitouch' => str_random(5),
            'RearCamera' => str_random(5),
            'FrontCamera' => str_random(5),
            'VideoRecording' => str_random(5),
            'RearCameraFeatures' => str_random(5),
            'MicroSDCS' =>str_random(5) ,
            'InternalMemory' => str_random(5) ,
            'RAM' => str_random(5),
            'WLAN' =>  str_random(5),
            'Bluetooth' => str_random(5),
            'GPS' => str_random(5),
            'USB' => str_random(5),
            'BatteryType' => str_random(5),
            'BatteryCapacity' => str_random(5),
            'BatteryRemovable' => str_random(5)
         ]); 
   */
/*   DB::table('countries')->insert([
       'name' => 'Canada',
       'code' => 'CAX',
       'region_id' => 1,
       'language_id' => 1
  ]); 


   DB::table('countries')->insert([
       'name' => 'Francia ',
       'code' => 'FR',
       'region_id' => 3,
       'language_id' => 3
  ]); 


   DB::table('countries')->insert([
       'name' => 'Venezuela',
       'code' => 'VE',
       'region_id' => 2,
       'language_id' => 2
  ]); 

  DB::table('product_countries')->insert([
       'product_id' => 1,
       'country_id' => 1     
  ]); 

 DB::table('product_countries')->insert([
       'product_id' => 2,
       'country_id' => 1     
  ]); 
    
       
DB::table('product_countries')->insert([
       'product_id' => 1,
       'country_id' => 2     
  ]); 

DB::table('product_countries')->insert([
       'product_id' => 3,
       'country_id' => 3     
  ]); 


 DB::table('product_countries')->insert([
       'product_id' => 1,
       'country_id' => 1     
  ]); */

    }
}
