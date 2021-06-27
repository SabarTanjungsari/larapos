<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.user', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User($request->all());
        $validator = Validator::make($request->all(), $user->rules);
        $errors = $validator->errors();
        $user['role'] = $request->role;

        if ($errors->any()) {
            $roles = Role::orderBy('name', 'ASC')->get();
            return view('users.user', compact('roles', 'user', 'errors'));
        }

        try {
            //default $photo = null
            $photo = null;
            //jika terdapat file (Foto / Gambar) yang dikirim
            if ($request->hasFile('photo')) {
                //maka menjalankan method saveFile()
                $photo = $this->saveFile($request->name, $request->file('photo'));
            }

            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'status' => 't',
                'photo' => $photo
            ]);
            $user->assignRole($request->role);

            //jika berhasil direct ke produk.index
            return redirect(route('users.index'))->with(['success' => 'User : <strong>' . $user->name . $user->status . '</strong> Added.']);
        } catch (\Exception $e) {
            //jika gagal, kembali ke halaman sebelumnya kemudian tampilkan error
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Save the specified photo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveFile($name, $photo)
    {
        //set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
        $images = Str::slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        //set path untuk menyimpan gambar
        $path = public_path('uploads/user');

        Image::make($photo)->save($path . '/' . $images);

        return $images;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $role = $user->roles()->pluck('name');
        $user['role'] = $user->roles[0]['name'];

        return view('users.user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = new User(
            $request->all()
        );

        $rules = $user->rules;
        $rules['email'] = $rules['email'] . ',email,' . $id;
        $rules['password'] = 'nullable';
        $validator = Validator::make(
            request()->all(),
            $rules
        );
        $errors = $validator->errors();
        if ($errors->any()) {
            $roles = Role::orderBy('name', 'ASC')->get();
            return view('users.user', compact('user', 'roles', 'errors'));
        }

        $user = User::findOrFail($id);
        $password = !empty($request->password) ? bcrypt($request->password) : $user->password;

        try {
            $user = User::findOrFail($id);
            $photo = $user->photo;

            if ($request->hasFile('photo')) {
                !empty($photo) ? File::delete(public_path('uploads/user/' . $user->photo)) : null;

                $photo = $this->saveFile($request->name, $request->file('photo'));
            }

            $user->update([
                'name' => $request->name,
                'password' => $password,
                'email' => $request->email,
                'photo' => $photo
            ]);
            if ($user->roles[0]['name'] != $request->role) {
                $user->removeRole($user->roles[0]['name']);
                $user->assignRole($request->role);
            }

            if (auth()->user()->can('user-list')) {
                return redirect(route('users.index'))->with(['success' => 'User : <strong>' . $user->name . '</strong> Updated.']);
            } else {
                return redirect('login')->with(Auth::logout());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with(['success' => '<strong>' . $user->name . '</strong> Deleted.']);
    }
}
