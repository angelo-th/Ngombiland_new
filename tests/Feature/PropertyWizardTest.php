<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use App\Models\CrowdfundingProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyWizardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['role' => 'proprietor']);
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_create_a_property_without_crowdfunding()
    {
        Livewire::test('property-wizard')
            ->set('title', 'Test Property')
            ->set('description', 'This is a test property description that is long enough to pass validation')
            ->set('type', 'house')
            ->set('price', 50000000)
            ->set('location', 'Douala, Cameroun')
            ->set('latitude', 4.0483)
            ->set('longitude', 9.7043)
            ->set('is_crowdfundable', false)
            ->call('save')
            ->assertRedirect(route('properties.index'));
        
        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'description' => 'This is a test property description that is long enough to pass validation',
            'type' => 'house',
            'price' => 50000000,
            'location' => 'Douala, Cameroun',
            'latitude' => 4.0483,
            'longitude' => 9.7043,
            'is_crowdfundable' => false,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_can_create_a_property_with_crowdfunding()
    {
        Livewire::test('property-wizard')
            ->set('title', 'Crowdfunding Property')
            ->set('description', 'This is a test property description that is long enough to pass validation')
            ->set('type', 'villa')
            ->set('price', 100000000)
            ->set('location', 'Yaoundé, Cameroun')
            ->set('latitude', 3.8480)
            ->set('longitude', 11.5021)
            ->set('is_crowdfundable', true)
            ->set('expected_roi', 15.5)
            ->set('total_amount', 80000000)
            ->set('total_shares', 800)
            ->set('funding_deadline', now()->addDays(60)->format('Y-m-d'))
            ->call('save')
            ->assertRedirect(route('properties.index'));
        
        $this->assertDatabaseHas('properties', [
            'title' => 'Crowdfunding Property',
            'is_crowdfundable' => true,
            'expected_roi' => 15.5,
            'user_id' => $this->user->id
        ]);
        
        $this->assertDatabaseHas('crowdfunding_projects', [
            'title' => 'Crowdfunding Property - Projet de Crowdfunding',
            'total_amount' => 80000000,
            'total_shares' => 800,
            'expected_roi' => 15.5,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        Livewire::test('property-wizard')
            ->set('title', '')
            ->set('description', 'Short')
            ->set('price', 0)
            ->call('nextStep')
            ->assertHasErrors(['title', 'description', 'price']);
    }

    /** @test */
    public function it_validates_crowdfunding_fields_when_enabled()
    {
        Livewire::test('property-wizard')
            ->set('title', 'Test Property')
            ->set('description', 'This is a test property description that is long enough to pass validation')
            ->set('type', 'house')
            ->set('price', 50000000)
            ->set('location', 'Douala, Cameroun')
            ->set('latitude', 4.0483)
            ->set('longitude', 9.7043)
            ->set('is_crowdfundable', true)
            ->set('expected_roi', '')
            ->set('total_amount', '')
            ->set('total_shares', '')
            ->call('nextStep')
            ->assertHasErrors(['expected_roi', 'total_amount', 'total_shares']);
    }

    /** @test */
    public function it_calculates_price_per_share_correctly()
    {
        Livewire::test('property-wizard')
            ->set('is_crowdfundable', true)
            ->set('total_amount', 10000000)
            ->set('total_shares', 1000)
            ->assertSet('price_per_share', 10000);
    }

    /** @test */
    public function it_updates_price_per_share_when_amount_changes()
    {
        Livewire::test('property-wizard')
            ->set('is_crowdfundable', true)
            ->set('total_shares', 1000)
            ->set('total_amount', 20000000)
            ->assertSet('price_per_share', 20000);
    }

    /** @test */
    public function it_updates_price_per_share_when_shares_change()
    {
        Livewire::test('property-wizard')
            ->set('is_crowdfundable', true)
            ->set('total_amount', 10000000)
            ->set('total_shares', 500)
            ->assertSet('price_per_share', 20000);
    }

    /** @test */
    public function it_navigates_through_steps_correctly()
    {
        Livewire::test('property-wizard')
            ->assertSet('currentStep', 1)
            ->call('nextStep')
            ->assertSet('currentStep', 2)
            ->call('nextStep')
            ->assertSet('currentStep', 3)
            ->call('nextStep')
            ->assertSet('currentStep', 4)
            ->call('previousStep')
            ->assertSet('currentStep', 3);
    }

    /** @test */
    public function it_prevents_going_to_previous_step_from_first_step()
    {
        Livewire::test('property-wizard')
            ->assertSet('currentStep', 1)
            ->call('previousStep')
            ->assertSet('currentStep', 1);
    }

    /** @test */
    public function it_removes_images_correctly()
    {
        // Simuler l'upload d'images (dans un vrai test, on utiliserait des fichiers de test)
        Livewire::test('property-wizard')
            ->set('images', ['image1.jpg', 'image2.jpg', 'image3.jpg'])
            ->call('removeImage', 1)
            ->assertSet('images', ['image1.jpg', 'image3.jpg']);
    }

    /** @test */
    public function it_removes_documents_correctly()
    {
        // Simuler l'upload de documents
        Livewire::test('property-wizard')
            ->set('documents', ['doc1.pdf', 'doc2.pdf', 'doc3.pdf'])
            ->call('removeDocument', 0)
            ->assertSet('documents', ['doc2.pdf', 'doc3.pdf']);
    }
}
