<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;
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

    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(\App\User::class)->create(),'api');
        $response = $this->post('/api/posts',[
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'Testing Body',
                ]
            ]
        ]);

        $post=Post::first();

        $this->assertCount(1,Post::all());
        $this->assertEquals(user_id,$post->user_id);
        $this->assertEquals('Testing Body',$post->body);

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'type' => 'posts',
                'post_id' => $post->id,
                'attribute' => [
                    'posted_by' => [
                        'data' => [
                            'attribute' => [
                                'name' => $user->name,
                            ]
                        ]
                        
                    ],
                    'body' => 'Testing Body',
                ]
                ],
                'links' => [
                    'self' => url('/posts/'.$post->id),
                ]
        ]);
    }
}
