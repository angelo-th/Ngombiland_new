namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;

class AgentGeo extends Component
{
    public $propertyId;
    public $lat;
    public $lng;

    public function validateGeo(){
        $this->validate([
            'propertyId'=>'required|exists:properties,id',
            'lat'=>'required|numeric',
            'lng'=>'required|numeric'
        ]);

        $property = Property::find($this->propertyId);
        $property->update(['lat'=>$this->lat,'lng'=>$this->lng]);
        session()->flash('success','Géolocalisation validée');
    }

    public function render(){
        $properties = Property::all();
        return view('livewire.agent-geo', compact('properties'));
    }
}
