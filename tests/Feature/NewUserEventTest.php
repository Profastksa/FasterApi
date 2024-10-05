<?php
use Tests\TestCase;
use App\Models\Representative;
use App\Events\NewUserCreated;
use Illuminate\Support\Facades\Event;

class NewUserEventTest extends TestCase
{
    public function testNewRepresentativeEvent()
    {
        // Ensure that the NewUserCreated event is dispatched when a new Representative is created
        Event::fake();

        // Create a new Representative
        $representative = Representative::factory()->create();

        // Assert that the NewUserCreated event was dispatched
        Event::assertDispatched(NewUserCreated::class, function ($event) use ($representative) {
            return $event->getModel()->id === $representative->id;
        });

        // Assert that the Representative was created successfully
        $this->assertDatabaseHas('representatives', [
            'id' => $representative->id,
            // Add other assertions as needed
        ]);
    }
}
