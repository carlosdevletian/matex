<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactEmailTest extends TestCase
{
    private $response;

    private function sendContactEmail($attributes)
    {
        $this->response = $this->json('POST', "/contact", $attributes);
    }
    /** @test */
    public function email_address_is_required_to_send_contact_email()
    {
        $this->withExceptionHandling();
        $this->sendContactEmail([
            'email' => 'invalid_email_address',
            'subject' => 'An example subject',
            'body' => 'An example body'
        ]);

        $this->response->assertStatus(422);
        $this->response->assertJson(['email' => true]);
    }
    /** @test */
    public function email_address_must_be_valid_to_send_contact_email()
    {
        $this->withExceptionHandling();
        $this->sendContactEmail([
            'email' => 'valid_address@example.com',
            'subject' => 'An example subject',
            'body' => 'An example body'
        ]);

        $this->response->assertStatus(201);
    }

    /** @test */
    public function subject_is_required_to_send_contact_email()
    {
        $this->withExceptionHandling();
        $this->sendContactEmail([
            'email' => 'john@example.com',
            'body' => 'An example body'
        ]);

        $this->response->assertStatus(422);
        $this->response->assertJson(['subject' => true]);
    }

    /** @test */
    public function body_is_required_to_send_contact_email()
    {
        $this->withExceptionHandling();
        $this->sendContactEmail([
            'email' => 'john@example.com',
            'subject' => 'An example subject'
        ]);

        $this->response->assertStatus(422);
        $this->response->assertJson(['body' => true]);
    }
}
