<?php

namespace Tests\Feature;

use App\Recipe;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    use RefreshDatabase;
    protected $user;
    //Create user and authenticate the user
    protected function authenticate(){
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $token = JWTAuth::fromUser($user);
        return $token;
    }


    public function testCreate()
    {
        //Get token
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',route('recipe.create'),[
            'title' => 'Jollof Rice',
            'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
        ]);
        $response->assertStatus(200);
        //Get count and assert
        $count = User::where('email','test@gmail.com')->first()->recipes()->count();
        $this->assertEquals(1,$count);

    }

    //     //Test the display all routes
    // public function testAll(){
    //     //Authenticate and attach recipe to user
    //     $token = $this->authenticate();
    //     $recipe = Recipe::create([
    //         'title' => 'Jollof Rice',
    //         'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
    //     ]);
    //     $this->user->recipes()->save($recipe);

    //     //call route and assert response
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('GET',route('recipe.all'));
    //     $response->assertStatus(200);

    //     //Assert the count is 1 and the title of the first item correlates
    //     $this->assertEquals(1,count($response->json()));
    //     $this->assertEquals('Jollof Rice',$response->json()[0]['title']);
    // }
    // //Test the update route
    // public function testUpdate(){
    //     $token = $this->authenticate();
    //     $recipe = Recipe::create([
    //         'title' => 'Jollof Rice',
    //         'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
    //     ]);
    //     $this->user->recipes()->save($recipe);

    //     //call route and assert response
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('POST',route('recipe.update',['recipe' => $recipe->id]),[
    //         'title' => 'Rice',
    //     ]);
    //     $response->assertStatus(200);

    //     //Assert title is the new title
    //     $this->assertEquals('Rice',$this->user->recipes()->first()->title);
    // }
    // //Test the single show route
    // public function testShow(){
    //     $token = $this->authenticate();
    //     $recipe = Recipe::create([
    //         'title' => 'Jollof Rice',
    //         'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
    //     ]);
    //     $this->user->recipes()->save($recipe);
    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('GET',route('recipe.show',['recipe' => $recipe->id]));
    //     $response->assertStatus(200);

    //     //Assert title is correct
    //     $this->assertEquals('Jollof Rice',$response->json()['title']);
    // }
    // //Test the delete route
    // public function testDelete(){
    //     $token = $this->authenticate();
    //     $recipe = Recipe::create([
    //         'title' => 'Jollof Rice',
    //         'procedure' => 'Parboil rice, get pepper and mix, and some spice and serve!'
    //     ]);
    //     $this->user->recipes()->save($recipe);

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer '. $token,
    //     ])->json('POST',route('recipe.delete',['recipe' => $recipe->id]));
    //     $response->assertStatus(200);

    //     //Assert there are no recipes
    //     $this->assertEquals(0,$this->user->recipes()->count());
    // }
}