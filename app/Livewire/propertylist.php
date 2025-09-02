namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertyList extends Component
{
    public $properties;

    public function mount(){
        $this->properties = Property::with('owner')->latest()->get();
    }

    public function render(){
        return view('livewire.property-list');
    }
}
