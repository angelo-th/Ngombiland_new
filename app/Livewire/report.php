namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;

class AgentReport extends Component
{
    public $description;

    public function submitReport(){
        $this->validate(['description'=>'required|string']);

        Report::create([
            'agent_id'=>auth()->id(),
            'description'=>$this->description
        ]);

        $this->description = '';
        session()->flash('success','Rapport soumis avec succès');
    }

    public function render(){
        $reports = Report::where('agent_id',auth()->id())->latest()->get();
        return view('livewire.agent-report', compact('reports'));
    }
}
class Report extends Model
{
    use HasFactory;
    protected $fillable = ['agent_id','property_id','description','geo_lat','geo_lng','status'];
    public function agent() { return $this->belongsTo(User::class,'agent_id'); }
    public function property() { return $this->belongsTo(Property::class); }
}
<?php