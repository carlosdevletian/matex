<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactEmailTest extends TestCase
{
    private function sendContactEmail($attributes)
    {
        $this->json('POST', "/contact", $attributes);
    }
    /** @test */
    public function email_address_is_required_to_send_contact_email()
    {
        $this->sendContactEmail([
            'email' => 'invalid_email_address',
            'subject' => 'An example subject',
            'body' => 'An example body'
        ]);

        $this->assertResponseStatus(422);
        $this->assertArrayHasKey('email', $this->decodeResponseJson());
    }
    /** @test */
    public function email_address_must_be_valid_to_send_contact_email()
    {
        $this->sendContactEmail([
            'email' => 'valid_address@example.com',
            'subject' => 'An example subject',
            'body' => 'An example body'
        ]);

        $this->assertResponseStatus(201);
    }
    
    /** @test */
    public function subject_is_required_to_send_contact_email()
    {
        $this->sendContactEmail([
            'email' => 'john@example.com',
            'body' => 'An example body'
        ]);

        $this->assertResponseStatus(422);
        $this->assertArrayHasKey('subject', $this->decodeResponseJson());
    }

    /** @test */
    public function body_is_required_to_send_contact_email()
    {
        $this->sendContactEmail([
            'email' => 'john@example.com',
            'subject' => 'An example subject'
        ]);

        $this->assertResponseStatus(422);
        $this->assertArrayHasKey('body', $this->decodeResponseJson());
    }
}
