<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id_type = ProductType::select('id')->get()->toArray();
        return [
            "id_type" =>array_rand($id_type),
            "name" => $this->faker->name,
            "description" => $this->faker->text(),
            "unit_price" =>$this->faker->randomDigit,
            "promotion_price" =>$this->faker->randomDigit,
            "image" => $this->faker->image('public/images',100,300,null,false),
            "unit" => $this->faker->text(),
            "new" => $this->faker->randomDigit,
        ];
    }
}
