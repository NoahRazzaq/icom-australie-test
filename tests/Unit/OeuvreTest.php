<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Oeuvre;

class OeuvreApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test de création d'une œuvre via API.
     *
     * @return void
     */
    public function test_creer_une_oeuvre_via_api()
    {
        $response = $this->postJson('/api/oeuvres', [
            'titre' => 'titre',
            'description' => 'Description',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('oeuvres', ['titre' => 'titre']);
    }

    /**
     * Test de récupération d'une œuvre via API.
     *
     * @return void
     */
    public function test_recuperer_une_oeuvre_via_api()
    {
        $oeuvre = Oeuvre::factory()->create();

        $response = $this->getJson('/api/oeuvres/' . $oeuvre->id);

        $response->assertStatus(200);
        $response->assertJson(['id' => $oeuvre->id]);
    }

    /**
     * Test de mise à jour d'une œuvre via API.
     *
     * @return void
     */
    public function test_modifier_une_oeuvre_via_api()
    {
        $oeuvre = Oeuvre::factory()->create();

        $response = $this->putJson('/api/oeuvres/' . $oeuvre->id, [
            'titre' => 'La joconde',
            'description' => 'jonconde de leonardo da vinci',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('oeuvres', ['titre' => 'La joconde']);
    }

    /**
     * Test de suppression d'une œuvre via API.
     *
     * @return void
     */
    public function test_supprimer_une_oeuvre_via_api()
    {
        $oeuvre = Oeuvre::factory()->create();

        $response = $this->deleteJson('/api/oeuvres/' . $oeuvre->id);

        $response->assertStatus(204); 
        $this->assertDatabaseMissing('oeuvres', ['id' => $oeuvre->id]);
    }
}
