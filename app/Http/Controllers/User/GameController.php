<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display the available games for users in a read-only listing.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->get('q'));
        $typeFilter = $request->get('type');
        $levelFilter = $request->get('level');

        $gamesQuery = Game::query();

        if ($search !== '') {
            $gamesQuery->where(function ($query) use ($search) {
                $like = '%' . $search . '%';
                $query
                    ->where('name', 'like', $like)
                    ->orWhere('genre', 'like', $like)
                    ->orWhere('type', 'like', $like);
            });
        }

        if (!in_array($typeFilter, ['original', 'free'], true)) {
            $typeFilter = null;
        }

        if ($typeFilter) {
            $gamesQuery->where('type', $typeFilter);
        }

        if ($levelFilter === '1') {
            $gamesQuery->where('level', 1);
        } elseif ($levelFilter === '2_plus') {
            $gamesQuery->where('level', '>=', 2);
        } else {
            $levelFilter = null;
        }

        $games = $gamesQuery
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('user.games', [
            'games' => $games,
            'search' => $search,
            'selectedType' => $typeFilter,
            'selectedLevel' => $levelFilter,
        ]);
    }
}
