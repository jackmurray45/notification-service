<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Token;
use App\Notification;
use App\NotificationLog;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\NotificationCreated;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\Support\Facades\Queue;
use App\Notifications\Send;

class NotificationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function create_notification_with_token()
    {
        $token = factory(Token::class)->create();

        $token->notifications()->create($this->data());

        $this->assertCount(1, Notification::all());
        $this->assertCount(1, $token->notifications);

    }

    /** @test */
    public function notification_logs_created_and_sent_on_notification_created_event()
    {
        // Initialization...
        $token = factory(Token::class)->create();
        $notification = $token->notifications()->create($this->data());
    
        event(new NotificationCreated($notification));

        $this->assertCount(2, NotificationLog::where('status', 'sent')->get());

    }

    private function data()
    {
        return [
            'type' => 'mail',
            'recipients' => 'jack@hello.com,brian@test.com',
            'status' => 'pending',
            'content' => '<h1>Hello World!</h1>'
        ];
    }
    

    
}
