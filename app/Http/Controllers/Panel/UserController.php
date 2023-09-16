<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidatorFormRequest;
use App\Models\User;
use App\Reports\UserReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'User';

        $users = $this->user->paginate(User::TOTAL_PAGE);

        return view('panel.user.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Usuário';

        return view('panel.user.form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidatorFormRequest $request)
    {
        $newName = null;

        // faz upload da imagem e salva dentro da pasta public/uploads/users
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $newName = strval(uniqid(date('HisYmd'))).'.'.$request->image->extension();

            /* users é a pasta onde será feito o upload junto com o caminho especificados na variável
             root do arquivo filesystems.php em /config
             */
            if (! $request->image->storeAs('users', $newName)) {
                return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!')->withInput();
            }
        }

        // altera o campo imagem para receber o novo nome da imagem a ser salva no banco de dados
        $dataForm = $request->all();
        $dataForm['image'] = $newName;

        //         if ($request->password && $request->password != '') {
        //             $dataForm['password'] = bcrypt($dataForm['password']);
        //         } else {
        //             unset($dataForm['password']);
        //         }

        if ($this->user->create($dataForm)) {
            return redirect()
                ->route('users.index')
                ->with('success', "Usuário {$request->name} cadastrado com sucesso!");
        }

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        if (! $user) {
            return redirect()->back();
        }

        $title = 'Detalhes do Usuário: '.$user->name;

        return view('panel.user.show', compact('title', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        if (! $user) {
            return redirect()->back();
        }

        $title = 'Editar Usuário: '.$user->name;

        return view('panel.user.form', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserValidatorFormRequest $request, $id)
    {
        $newName = null;
        $dataForm = $request->all();

        $user = $this->user->find($id);
        if (! $user) {
            return redirect()->back();
        }

        // faz upload da imagem e salva dentro da pasta public/uploads/users
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $newName = strval(uniqid(date('HisYmd'))).'.'.$request->image->extension();

            /* users é a pasta onde será feito o upload junto com o caminho especificados na variável
             root do arquivo filesystems.php em /config
             */
            if (! $request->image->storeAs('users', $newName)) {
                return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!')->withInput();
            }

            // Deleta a imagem antiga depois de fazer o upload da nova
            $path_file = public_path().'/uploads/users/'.$user->image;
            if (File::exists($path_file)) {
                File::delete($path_file);
            }

            $dataForm['image'] = $newName;
        }

        //         if ($request->password && $request->password != '') {
        //             $dataForm['password'] = bcrypt($dataForm['password']);
        //         } else {
        //             unset($dataForm['password']);
        //         }

        if ($user->update($dataForm)) {
            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar Usuário!')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'Usuário não encontrado!');
        }

        // Deleta a imagem do usuário se existir
        $path_file = public_path().'/uploads/users/'.$user->image;
        if (File::exists($path_file)) {
            File::delete($path_file);
        }

        // deleta o usuário
        if ($user->delete()) {
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao excluir Usuário')->withInput();
    }

    public function search(Request $request)
    {
        // recuperar os dados do form para que sejam reenviados para view para preservá-lo o filtro
        $dataForm = $request->all();
        $users = $this->user->search($request);

        $title = 'Resultado de usuários pesquisados';

        return view('panel.user.index', compact('title', 'users', 'dataForm'));
    }

    public function report()
    {
        $data = User::orderBy('name', 'asc')->get()->toArray();

        $pdf = new UserReport('L', 'mm', 'A4');
        $pdf->generateReport($pdf, 'Relatórios de Usuários', $data);
    }
}
