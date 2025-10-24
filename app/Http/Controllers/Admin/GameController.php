<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    // لیست بازی‌ها
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $status = $request->get('status', '');
        $genre = trim($request->get('genre', ''));

        $games = Game::query()
            ->when($q, fn($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->when($genre, fn($qr) => $qr->where('genre', 'like', "%{$genre}%"))
            ->when(in_array($status, ['active','inactive'], true), fn($qr) => $qr->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.games', compact('games', 'q', 'status', 'genre'));
    }

    // ایجاد بازی جدید
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:150'],
            'genre'  => ['nullable','string','max:100'],
            'status' => ['required','in:active,inactive'],
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
