<?php

namespace Juzaweb\Modules\SupportTicket\Tests\Feature;

use Juzaweb\Modules\SupportTicket\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;
use Juzaweb\Modules\SupportTicket\Models\SupportTicket;
use Juzaweb\Modules\SupportTicket\Models\SupportTicketReply;

class SupportTicketApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('auth.guards.api', [
            'driver' => 'session',
            'provider' => 'users',
        ]);
    }

    public function test_can_get_tickets(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        SupportTicket::create([
            'subject' => 'Test',
            'content' => 'Test',
            'status' => 'open',
            'ticketable_type' => get_class($user),
            'ticketable_id' => $user->getKey(),
        ]);

        $response = $this->getJson('/api/v1/support-tickets');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'subject',
                    'content',
                    'status',
                ]
            ]
        ]);
    }

    public function test_can_show_ticket(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $ticket = SupportTicket::create([
            'subject' => 'Test',
            'content' => 'Test',
            'status' => 'open',
            'ticketable_type' => get_class($user),
            'ticketable_id' => $user->getKey(),
        ]);

        $response = $this->getJson("/api/v1/support-tickets/{$ticket->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'subject',
                'content',
                'status',
            ]
        ]);
    }

    public function test_can_get_ticket_replies(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $ticket = SupportTicket::create([
            'subject' => 'Test',
            'content' => 'Test',
            'status' => 'open',
            'ticketable_type' => get_class($user),
            'ticketable_id' => $user->getKey(),
        ]);

        $reply = new SupportTicketReply([
            'ticket_id' => $ticket->id,
            'content' => 'Test reply',
            'is_staff_reply' => false,
        ]);
        $reply->setAttribute('created_by', $user->getKey());
        $reply->setAttribute('created_type', get_class($user));
        $reply->save();

        $response = $this->getJson("/api/v1/support-tickets/{$ticket->id}/replies");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'ticket_id',
                    'content',
                    'is_staff_reply',
                ]
            ]
        ]);
    }

    public function test_can_create_ticket(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/v1/support-tickets', [
            'subject' => 'Test Subject',
            'content' => 'Test Content',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'subject',
                'content',
                'status',
            ]
        ]);
    }

    public function test_can_reply_ticket(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $ticket = SupportTicket::create([
            'subject' => 'Test',
            'content' => 'Test',
            'status' => 'open',
            'ticketable_type' => get_class($user),
            'ticketable_id' => $user->getKey(),
        ]);

        $response = $this->postJson("/api/v1/support-tickets/{$ticket->id}/reply", [
            'content' => 'Test Reply Content',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'ticket_id',
                'content',
                'is_staff_reply',
            ]
        ]);
    }
}
