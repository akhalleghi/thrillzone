<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
   
    public function index(Request $request)
{
    $q      = trim($request->get('q', ''));
    $status = $request->get('status', '');
    $genre  = trim($request->get('genre', ''));
    $type   = $request->get('type', ''); // 👈 فیلتر جدید نوع بازی
    $level  = $request->get('level', '');  // '1' | '2' | ''


    $games = Game::query()
        ->when($q, fn($qr) => 
            $qr->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('genre', 'like', "%{$q}%");
            })
        )
        ->when($genre, fn($qr) => 
            $qr->where('genre', 'like', "%{$genre}%")
        )
        ->when(in_array($status, ['active', 'inactive'], true), fn($qr) => 
            $qr->where('status', $status)
        )
        ->when(in_array($type, ['free', 'original'], true), fn($qr) => 
            $qr->where('type', $type)
        )
        ->when(in_array($level, ['1','2'], true), fn($qr) =>
            $qr->where('level', (int)$level)
        )
        ->latest()
        ->paginate(12)
        ->withQueryString();

    return view('admin.games', compact('games', 'q', 'status', 'genre', 'type','level'));
}


    // ایجاد بازی جدید
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:150'],
            'genre'  => ['nullable','string','max:100'],
            'status' => ['required','in:active,inactive'],
            'type'   => ['required','in:free,original'],
            'level'  => ['required','integer','in:1,2'],
            'cover'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('games', 'public'); // storage/app/public/games/...
        }

        Game::create($data);

        return back()->with('success','بازی با موفقیت افزوده شد.');
    }

    // بروزرسانی بازی
    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:150'],
            'genre'  => ['nullable','string','max:100'],
            'status' => ['required','in:active,inactive'],
            'type'   => ['required','in:free,original'],
            'level'  => ['required','integer','in:1,2'],
            'cover'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            // حذف کاور قبلی (اگر بود)
            if ($game->cover && Storage::disk('public')->exists($game->cover)) {
                Storage::disk('public')->delete($game->cover);
            }
            $data['cover'] = $request->file('cover')->store('games', 'public');
        }

        $game->update($data);

        return back()->with('success','بازی با موفقیت ویرایش شد.');
    }

    // حذف بازی
    public function destroy(Game $game)
    {
        if ($game->cover && Storage::disk('public')->exists($game->cover)) {
            Storage::disk('public')->delete($game->cover);
        }

        $game->delete();

        return back()->with('success','بازی حذف شد.');
    }
}
