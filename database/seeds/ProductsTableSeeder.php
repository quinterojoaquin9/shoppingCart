<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Products([
            'imagePath' => 'https://www.100ladrillos.com/static/media/la-toscana.a1913daf.jpg',
            'title' => 'La Toscana, GDL',
            'description' => 'Super cool - at least as a child.',
            'price' => 150.429
        ]);
        $product->save();

        $product = new \App\Products([
            'imagePath' => 'https://www.100ladrillos.com/static/media/entorno-s.3dbf34ab.jpg',
            'title' => 'Entorno S, PTV',
            'description' => 'No one is going to survive!',
            'price' => 73.375
        ]);
        $product->save();

        $product = new \App\Products([
            'imagePath' => 'https://www.100ladrillos.com/static/media/sonata.b3aa6015.jpg',
            'title' => 'Sonata (Oficinas), GDL',
            'description' => 'I found the movies to be better ...',
            'price' => 280.210
        ]);
        $product->save();

        $product = new \App\Products([
            'imagePath' => 'http://ecx.images-amazon.com/images/I/919-FLL37TL.jpg',
            'title' => 'A Song of Ice and Fire - Game of Thrones',
            'description' => 'No one is going to survive!',
            'price' => 20.000
        ]);
        $product->save();

        $product = new \App\Products([
            'imagePath' => 'http://www.georgerrmartin.com/wp-content/uploads/2012/08/feastforcrows.jpg',
            'title' => 'A Song of Ice and Fire - A Feast for Crows',
            'description' => 'Still, no one is going to survive!',
            'price' => 10.000
        ]);
        $product->save();
    }
}
