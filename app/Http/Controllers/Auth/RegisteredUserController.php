<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function index()
    {
        foreach (json_decode(User::pluck('info'), true) as $element) {
            if(!empty($element) && $element['city'] !== null) {
                $data[] = $element['city'];
            }
        }

        // Проходимся по каждой записи и форматируем временные метки created_at
        $records = User::all();
        $formattedRecords = $records->map(function($record) {
            // Преобразуем временную метку created_at в объект Carbon
            $createdAt = Carbon::parse($record->created_at);

            // Форматируем время в нужный формат (только часы)
            $formattedTime = $createdAt->format('H');

            // Возвращаем отформатированное время в виде строки
            return $formattedTime;
        });

// Выводим отформатированные временные метки
        foreach ($formattedRecords as $formattedTime) {
            $time[] = $formattedTime;
        }


//        dd($arr);
//        $data = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань'];

        return view('dashboard',['param' => array_slice($data ,0, 5),'time' => $time]);
    }


}
