<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsController extends Controller
{
    public function updatePasswordForm()
    {
        return view('admin.setting.changepassword');
    }

    public function updatePassword(Request $request)
    {   
        $request->validate([
          'old_password' => 'required',
          'new_password' => 'min:6|same:password_confirmation',
          'password_confirmation' => 'min:6|required'
        ],
        [
            'old_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.same' => 'Password baru tidak sama dengan konfirmasi password',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'password_confirmation.min' => 'Konfirmasi password minimal 6 karakter',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',            
        ]);
        if(Hash::check($request->old_password , auth()->user()->password)) {
            if(!Hash::check($request->new_password , auth()->user()->password)) {
               $user = User::find(auth()->id());
               $user->update([
                   'password' => bcrypt($request->new_password)
               ]);               
               return redirect()->route('update.password')->with('success', 'Password berhasil diganti');
            }
            return redirect()->route('update.password')->with('warning', 'Password baru tidak boleh sama dengan password lama');
        }        
        return redirect()->route('update.password')->with('warning', 'Password lama salah');
    }
}
