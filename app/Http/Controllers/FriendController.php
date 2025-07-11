<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;

class FriendController extends Controller
{
    public function index()
    {
        $friends = auth()->user()->friends;
        $pendingRequests = auth()->user()->receivedFriendRequests()->where('status', 'pending')->with('sender')->get();
        return view('friends.index', compact('friends', 'pendingRequests'));
    }

    public function search(Request $request)
    {
        $users = User::where('username', 'like', '%' . $request->search . '%')
                     ->where('id', '!=', auth()->id())
                     ->limit(10)
                     ->get();
        return response()->json($users);
    }
    
    public function add(User $user)
    {
        // Нельзя добавить себя или уже существующего друга/запрос
        // (логику проверки стоит добавить)
        
        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
        ]);
        
        return back()->with('success', 'Запрос в друзья отправлен!');
    }

    public function accept(Friendship $request)
    {
        $request->update(['status' => 'accepted']);
        return back()->with('success', 'Запрос в друзья принят!');
    }
    
    public function decline(Friendship $request)
    {
        $request->update(['status' => 'declined']);
        return back()->with('success', 'Запрос в друзья отклонен.');
    }
}