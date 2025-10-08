<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_ユーザーはツイートをブックマークできる()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->create();

        $response = $this->actingAs($user)
                         ->post(route('bookmarks.store', $tweet->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    public function test_ユーザーはブックマークを解除できる()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->create();

        $user->bookmarks()->attach($tweet->id);

        $response = $this->actingAs($user)
                         ->delete(route('bookmarks.destroy', $tweet->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);
    }

    public function test_ブックマーク一覧ページを表示できる()
    {
        $user = User::factory()->create();
        $tweet = Tweet::factory()->create();

        $user->bookmarks()->attach($tweet->id);

        $response = $this->actingAs($user)
                         ->get(route('bookmarks.index'));

        $response->assertStatus(200);
        $response->assertSee($tweet->tweet);
    }
}

