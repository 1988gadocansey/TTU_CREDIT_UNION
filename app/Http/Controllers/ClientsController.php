<?php

namespace App\Http\Controllers;

use App\Entities\Client;
use App\Entities\NextOfKin;
use App\Entities\User;
use App\Http\Requests;
use App\Jobs\AddClientJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $clients = collect([]);

        if ($request->has('q')) {
            $term = $request->get('q');

            $clients = Client::with(['clientable', 'createdBy'])->search($term);
        }

        if ($clients->count() === 1) {
            return redirect()->route('clients.show', ['client' => $clients->first()]);
        }

        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        if ($request->has('type')) {

            $typeOfClient = $request->get('type', null);

            $client = new Client;
            $relationshipManagers = User::all();
            $pageTitle = sprintf('Add new Client / %s Account', ucfirst($typeOfClient));

            return view('dashboard.clients.create', compact('client', 'relationshipManagers', 'pageTitle',
                'typeOfClient'));
        }

        return view('dashboard.clients.choose_type_of_client');

    }

    /**
     * @param Requests\AddClientFormRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Requests\AddClientFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $client = $this->dispatch(new AddClientJob($request));
            $client->nextOfKin()->create([
                'name' => $request->nextOfKin1Name,
                'relationship' => $request->nextOfKin1Relationship,
                'benefit' => $request->nextOfKin1Benefit,
                'address' => $request->nextOfKin1Address,
                'number' => 1
            ]);

            $client->nextOfKin()->create([
                'name' => $request->nextOfKin2Name,
                'relationship' => $request->nextOfKin2Relationship,
                'benefit' => $request->nextOfKin2Benefit,
                'address' => $request->nextOfKin2Address,
                'number' => 2
            ]);

            $client->nextOfKin()->create([
                'name' => $request->nextOfKin3Name,
                'relationship' => $request->nextOfKin3Relationship,
                'benefit' => $request->nextOfKin3Benefit,
                'address' => $request->nextOfKin3Address,
                'number' => 3
            ]);
            DB::commit();
            flash()->success('The Client has successfully been created');

            return redirect()->route('clients.show', ['client' => $client]);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Could not add client:', ['error' => $e->getMessage()]);

            flash()->error('The Client could not be created. Please try again');

            return redirect()->back()->withInput();
        }

    }

    public function show(Client $client)
    {
        $client->load('transactions.cashier', 'loans.schedule', 'loans.payoff');

        return view('dashboard.clients.show', compact('client'));
    }

    /**
     * @param Client $client
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Client $client)
    {
        $relationshipManagers = User::relationshipManagers();
        $pageTitle = 'Update Client';
        $typeOfClient = $client->clientable ? strtolower(substr($client->clientable->getMorphClass(), 5)) : '';

        return view('dashboard.clients.create', compact('client', 'relationshipManagers', 'pageTitle', 'typeOfClient'));
    }

    /**
     * @param Requests\AddClientFormRequest $request
     * @param Client $client
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Requests\AddClientFormRequest $request, Client $client)
    {
        DB::beginTransaction();
        try {
            $this->dispatch(new AddClientJob($request, $client));
            NextOfKin::find($request->nextOfKin2Id)->update([
                'name' => $request->nextOfKin2Name,
                'relationship' => $request->nextOfKin2Relationship,
                'benefit' => $request->nextOfKin2Benefit,
                'address' => $request->nextOfKin2Address,
            ]);
            NextOfKin::find($request->nextOfKin1Id)->update([
                'name' => $request->nextOfKin1Name,
                'relationship' => $request->nextOfKin1Relationship,
                'benefit' => $request->nextOfKin1Benefit,
                'address' => $request->nextOfKin1Address,
            ]);
            NextOfKin::find($request->nextOfKin3Id)->update([
                'name' => $request->nextOfKin3Name,
                'relationship' => $request->nextOfKin3Relationship,
                'benefit' => $request->nextOfKin3Benefit,
                'address' => $request->nextOfKin3Address,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Updating client failed', ['error' => $e->getMessage()]);

            flash()->error('The client could not be updated');

            return redirect()->back()->withInput();
        }

        flash()->success('Client has successfully been updated');

        return redirect()->route('clients.show', compact('client'));
    }
}
