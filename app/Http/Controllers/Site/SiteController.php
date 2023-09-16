<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveValidatorFormRequest;
use App\Http\Requests\UserProfileValidatorFormRequest;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteController extends Controller
{
    public function index(Airport $airport)
    {
        $title = 'Home Page';

        $airports = $airport->getAirportsWithCities();

        return view('site.home.index', compact('title', 'airports'));
    }

    public function promotions(Flight $flight)
    {
        $title = 'Promoções';

        $promotions = $flight->promotions();

        return view('site.promotions.list', compact('title', 'promotions'));
    }

    public function search(Request $request, Flight $flight)
    {
        $title = 'Resultados da Pesquisa de Voos';

        $origin = Airport::with('city')->find(intval($request->origin));
        $destination = Airport::with('city')->find(intval($request->destination));
        $date = formatDateAndTime($request->date);

        $flights = $flight->search($request);
        $filter_date = $request->input('filter_date');

        return view('site.home.search', compact('title', 'origin', 'destination', 'date', 'flights', 'filter_date'));
    }

    public function detailsFlight($id)
    {
        $flight = Flight::with(['origin', 'destination'])->find($id);
        if (! $flight) {
            return redirect()->back();
        }

        $title = 'Detalhes do Voo: '.$flight->id;

        return view('site.flight.details', compact('title', 'flight'));
    }

    public function reserveFlight(ReserveValidatorFormRequest $request, Reserve $reserve)
    {
        if ($reserve->newReserve($request->flight_id)) {
            return redirect()
                ->route('site.purchases')
                ->with('success', "Reservado o Voo <b>{$request->flight_id}</b> para o cliente: <b>"
                    .auth()->user()->name.'</b>');
        }

        return redirect()->back()->with('error', 'Falha ao reservar voo!');
    }

    public function myPurchases()
    {
        $title = 'Minhas compras';

        // obtém todas as reservas(compras) do usuário logado
        $purchases = auth()->user()->reserves()->orderBy('date_reserved', 'DESC')->get();

        return view('site.user.purchases', compact('title', 'purchases'));
    }

    public function purchaseDetail($id_reserve)
    {
        $reserve = Reserve::where('user_id', auth()->user()->id)->where('id', $id_reserve)->first();
        if (! $reserve) {
            return redirect()->back();
        }

        $flight = Flight::with(['origin.city', 'destination.city'])->find($reserve->flight_id);
        if (! $flight) {
            return redirect()->back();
        }

        $title = 'Detalhes do Voo: '.$flight->id;

        return view('site.user.details-purchase', compact('title', 'flight'));
    }

    public function myProfile()
    {
        $title = 'Meu Perfil';

        return view('site.user.profile', compact('title'));
    }

    public function updateProfile(UserProfileValidatorFormRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;

        // faz upload da imagem e salva dentro da pasta storage/public/flights
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $nameFile = strval(uniqid(date('HisYmd'))).'.'.$request->image->extension();

            if (! $request->image->storeAs('users', $nameFile)) {
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }

            // Deleta a imagem antiga depois de fazer o upload da nova
            $path_file = public_path().'/uploads/users/'.$user->image;
            if (File::exists($path_file)) {
                File::delete($path_file);
            }

            // seta o novo nome da imagem para no user
            $user->image = $nameFile;
        }

        if ($user->save()) {
            return redirect()->route('site.user.profile')
                ->with('success', "Perfil do usuário <b>{$user->name}</b> atualizado com sucesso!");
        } else {
            return redirect()
                ->back()->with('error', "Falha ao atualizar perfil do usuário <b>{$user->name}</b>");
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('site.index');
    }
}
