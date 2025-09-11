<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertyManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'proprietor']);
        $this->actingAs($this->user);
    }

    /** @test */
    public function authenticated_user_can_create_property()
    {
        $propertyData = [
            'title' => 'Villa moderne à Douala',
            'description' => 'Belle villa de 4 chambres avec jardin',
            'price' => 50000000,
            'location' => 'Douala, Cameroun',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
            'type' => 'villa',
        ];

        $response = $this->post('/properties', $propertyData);

        $response->assertRedirect('/properties');
        $this->assertDatabaseHas('properties', [
            'title' => 'Villa moderne à Douala',
            'user_id' => $this->user->id,
            'price' => 50000000,
        ]);
    }

    /** @test */
    public function property_creation_requires_authentication()
    {
        auth()->logout();

        $propertyData = [
            'title' => 'Test Property',
            'description' => 'Test Description',
            'price' => 1000000,
            'location' => 'Test Location',
        ];

        $response = $this->post('/properties', $propertyData);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_view_their_properties()
    {
        Property::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Ma propriété',
        ]);

        $response = $this->get('/properties');

        $response->assertStatus(200);
        $response->assertSee('Ma propriété');
    }

    /** @test */
    public function user_can_update_their_property()
    {
        $property = Property::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Ancien titre',
        ]);

        $updateData = [
            'title' => 'Nouveau titre',
            'description' => 'Nouvelle description',
            'price' => 7500000,
            'location' => 'Nouvelle localisation',
            'type' => 'villa',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
        ];

        $response = $this->put("/properties/{$property->id}", $updateData);

        $response->assertRedirect('/properties');
        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'Nouveau titre',
            'price' => 7500000,
        ]);
    }

    /** @test */
    public function user_can_delete_their_property()
    {
        $property = Property::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->delete("/properties/{$property->id}");

        $response->assertRedirect('/properties');
        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }

    /** @test */
    public function property_validation_works()
    {
        $invalidData = [
            'title' => '', // Required field empty
            'description' => 'Test',
            'price' => -1000, // Negative price
            'location' => 'Test',
        ];

        $response = $this->post('/properties', $invalidData);

        $response->assertSessionHasErrors(['title', 'price']);
    }

    /** @test */
    public function property_images_are_stored_correctly()
    {
        $propertyData = [
            'title' => 'Property with Images',
            'description' => 'Test property',
            'price' => 1000000,
            'location' => 'Test Location',
            'type' => 'apartment',
        ];

        $response = $this->post('/properties', $propertyData);

        $property = Property::where('title', 'Property with Images')->first();
        $this->assertNotNull($property);
        // TODO: Test image upload when file upload is properly implemented
    }

    /** @test */
    public function property_geolocation_is_stored_correctly()
    {
        $propertyData = [
            'title' => 'Geolocated Property',
            'description' => 'Test property with coordinates',
            'price' => 2000000,
            'location' => 'Yaoundé, Cameroun',
            'type' => 'apartment',
            'latitude' => 3.8480,
            'longitude' => 11.5021,
        ];

        $response = $this->post('/properties', $propertyData);

        $property = Property::where('title', 'Geolocated Property')->first();
        $this->assertNotNull($property);
        $this->assertEquals(3.8480, $property->latitude);
        $this->assertEquals(11.5021, $property->longitude);
    }

    /** @test */
    public function property_status_defaults_to_pending()
    {
        $propertyData = [
            'title' => 'Pending Property',
            'description' => 'Test property',
            'price' => 1000000,
            'location' => 'Test Location',
            'type' => 'apartment',
        ];

        $this->post('/properties', $propertyData);

        $property = Property::where('title', 'Pending Property')->first();
        $this->assertNotNull($property);
        $this->assertEquals('pending', $property->status);
    }
}
