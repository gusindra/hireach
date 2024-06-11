<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportContact;
use App\Exports\ExportContact;

class ContactController extends Controller
{
    public $user_info;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Your auth here
            $this->user_info = auth()->user();
            if ($this->user_info) {
                return $next($request);
            }
            abort(404);
        });
    }

    public function index(Request $request)
    {
        // if($request->has('v')){
        //     return view('main-side.user');
        // }
        //return view('user.company-table');
        $client = Client::latest()->paginate(15);
        if ($request->has('v')) {

            return view('contact.index', ['client' => $client]);
        }

        return view('resource.contact');
    }

    public function show(Request $request, $client)
    {
        $client = Client::where('uuid', $client)->first();

        // return view('user.contact-profile', ['user'=>$client]);

        // if ($request->has('v')) {
        // }

        return view('contact.edit', ['user' => $client]);
        //return view('user.contact-profile', ['user' => $client]);
        // return redirect('user');
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $uuid = Str::uuid()->toString();

        $data = [
            'uuid' => $uuid,
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_id' => auth()->user()->id,
        ];

        Client::create($data);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully!');
    }

    public function edit($uuid)
    {
        $client = Client::where('uuid', $uuid)->firstOrFail();

        return view('contact.edit', ['client' => $client]);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $client = Client::where('uuid', $uuid)->firstOrFail();

        $client->title = $request->title;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->save();
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }


    public function destroy($uuid)
    {
        $client = Client::where('uuid', $uuid)->firstOrFail();

        $client->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
    public function audience(Request $request)
    {
        // if($request->has('v')){
        //     return view('main-side.user');
        // }
        //return view('user.company-table');
        return view('resource.audience');
    }

    public function audienceShow(Request $request, $audience)
    {
        $data = Audience::find($audience);

        return view('resource.show-audience', ['user' => $data]);
        // return redirect('user');
    }

    public function profile(Client $client)
    {
        return view('user.user-profile', ['user' => $client]);
        // if($client->name != 'Admin'){
        // }
        // return redirect('user');
    }

    public function balance(Client $client, Request $request)
    {
        // if($user->name != 'Admin'){
        return view('user.user-balance', ['user' => $client, 'team' => $request->has('team') ? $request->team : 0]);
        // }
        // return redirect('user');
    }

    public function showFormImport()
    {
        return view('contact.import');
    }

    /**
     * This to import contact from file
     *
     * @param  mixed $request
     * @return void
     */
    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        if($file->getClientMimeType()=="text/csv"){
            foreach ($fileContents as $key => $line) {
                if ($key > 0) {
                    $data = str_getcsv($line);
                    //dd($data);
                    $perData = explode(',', $data[0]);
                    // return $perData[1];
                    $exsist = Client::where('user_id', auth()->user()->id)->where('phone', $perData[1])->count();
                    if ($exsist == 0) {
                        Client::create([
                            'uuid'      => Str::uuid(),
                            'name' => $perData[0],
                            'phone' => $perData[1],
                            'email' => $perData[2],
                            'user_id' => auth()->user()->id,
                            'created_at' => date('Y-m-d H:i:s')
                            // Add more fields as needed
                        ]);
                    }
                }
            }
        }else{
            Excel::import(new ImportContact, $request->file('file')->store('files'));
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    /**
     * This to export contact as csv file.
     *
     * @param  mixed $request
     * @return void
     */
    public function export(Request $request)
    {
        if($request->mime=="application"){
            return Excel::download(new ExportContact, $request->name.'_client.xlsx');
        }else{
            $table = Client::where('user_id', auth()->user()->id)->get();
            $filename = "tweets.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('name', 'phone', 'email', 'created_at'));

            foreach ($table as $row) {
                fputcsv($handle, array($row['name'], $row['phone'],$row['email'], $row['created_at']));
            }

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'client.csv', $headers);
        }
    }
}
