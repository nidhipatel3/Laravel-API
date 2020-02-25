<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrievePostsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
        public function a_user_can_retrive_posts()
        {
            $this->withoutExceptionHandling();

            $this->actingAs($user = factory(\App\User::class)->create(),'api');
            $posts = factory(\App\Post::class,2)->create(['user_id' => $user->id]);   
            $response = $this->get('/api/posts');
        
            $resource->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                                'image' => $posts->last()->image,
                                'posted_at' => $posts->last()->cretaed_at->diffForHumans(),
                                ]
                        ]
                            ],
                            [
                                'data' => [
                                    'type' => 'posts',
                                    'post_id' => $posts->first()->id,
                                    'attributes' => [
                                        'body' => $posts->first()->body,
                                        'image' => $posts->first()->image,
                                        'posted_at' => $posts->first()->cretaed_at->diffForHumans(),
                                        ]
                                ]
                            ]
                        ],
                        'links' => [
                            'self' => url('/posts'),
                        ]

                
        ]);
    }

    public function a_user_can_only_retrive_their_posts()
    {
        $this->actingAs($user = factory(\App\User::class)->create(),'api');
            $posts = factory(\App\Post::class)->create();   
            $response = $this->get('/api/posts');
        
            $resource->assertStatus(200)
            ->assertExactJson([
                'data' => [],
                'links' => [
                    'self' => url('/posts'),
                ]
            ]);
    }
    
}
