<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $categoryId = Category::inRandomOrder()->value('id');

        return [
            'category_id' => $categoryId,
            'first_name'  => $this->faker->lexify('??????'),
            'last_name'   => $this->faker->lexify('??????'),
            'gender'      => $this->faker->numberBetween(1, 3),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $this->faker->numerify('0##########'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'detail'      => $this->faker->realText(100),
        ];
    }
}
