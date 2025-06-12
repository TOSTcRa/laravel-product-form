<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::orderByDesc('created_at')->get();
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0'
        ]);

        $product = Product::create($data);

        $jsonPath = storage_path('app/products.json');
        $products = Product::all();
        Storage::put('products.json', $products->toJson());

        $xml = new \SimpleXMLElement('<products/>');
        foreach ($products as $p) {
            $item = $xml->addChild('product');
            $item->addChild('name', $p->name);
            $item->addChild('quantity', $p->quantity);
            $item->addChild('price', $p->price);
            $item->addChild('created_at', $p->created_at);
        }
        $xml->asXML(storage_path('app/products.xml'));

        return response()->json(['success' => true]);
    }
}