namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestProperty extends Component
{
    public $property;
    public $amount;

    public function mount(Property $property){
        $this->property = $property;
    }

    public function invest(){
        $this->validate(['amount'=>'required|numeric|min:1000']);

        Investment::create([
            'user_id'=>Auth::id(),
            'property_id'=>$this->property->id,
            'amount'=>$this->amount
        ]);

        session()->flash('success','Investissement réussi !');
    }

    public function render(){
        return view('livewire.invest-property');
    }
}
