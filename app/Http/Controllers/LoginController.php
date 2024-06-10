<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Tb_admin;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function loginproses(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/beranda');
            } elseif ($user->role == 'guru') {
                return redirect('/berandaguru');
            } elseif ($user->role == 'siswa') {
                return redirect('/berandasiswa');
            }
        }
        return redirect('/login');
    }

    public function register()
    {
        $gurus = Guru::whereNull('user_id')->get();
        $admins = Tb_admin::whereNull('user_id')->get();
        $siswas = Siswa::whereNull('user_id')->get();
    
        return view('login.register', compact('gurus', 'admins', 'siswas'));
    }
    

    public function registeruser(Request $request)
    {
        // Split value into name and id
        $nameIdArray = explode('-', $request->name);
        $name = $nameIdArray[0];
        $id = $nameIdArray[1];
    
        // Buat user baru
        $user = new User();
        $user->name = $name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(60);
        $user->save();
    
        // Update tabel sesuai dengan role dan id yang diperoleh dari select box
        switch ($request->role) {
            case 'guru':
                Guru::where('id_guru', $id)->update(['user_id' => $user->id]);
                break;
            case 'admin':
                Tb_admin::where('id_admin', $id)->update(['user_id' => $user->id]);
                break;
            case 'siswa':
                Siswa::where('id_siswa', $id)->update(['user_id' => $user->id]);
                break;
        }
    
        return redirect('/users')->with('success', 'Data Berhasil Ditambahkan');
    }
    
    

    public function logout()
    {
        Auth::logout();
        return \redirect('/login');
    }

    public function users(Request $request)
    {
        $search = $request->input('search');

        $query = User::orderByRaw("CASE WHEN role = 'admin' THEN 1 WHEN role = 'guru' THEN 2 ELSE 3 END");

        // Query untuk mencari
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->get();

        return view('users.datausers', compact('data', 'search'));
    }


    public function tampildatauser(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        return view('users.edituser', compact('data'));
    }

    public function updatedatauser(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        $data->name = $request->name;
        $data->role = $request->role;
        $data->email = $request->email;
        $password_old = $data->password;
        if (!$request->password) {
            $data->password = $password_old;
        }
        else {
            $data->password = Hash::make($request->password);
        }
        $data->remember_token = Str::random(60);
        $data->save();
        return Redirect('/users')->with('update', "Data Berhasil Diupdate");
    }

    public function deletedatauser(Request $request, $id)
    {
        // Hapus pengguna dari tabel users
        User::where('id', $id)->delete();
    
        // Atur user_id menjadi null pada tabel yang terkait
        Guru::where('user_id', $id)->update(['user_id' => null]);
        Tb_admin::where('user_id', $id)->update(['user_id' => null]);
        Siswa::where('user_id', $id)->update(['user_id' => null]);
    
        return redirect('/users')->with('success', 'Data Berhasil Dihapus');
    }
    
}
