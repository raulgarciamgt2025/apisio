<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\MenuRepositoryInterface;

class MenuController extends Controller
{
    protected $menuRepo;

    public function __construct(MenuRepositoryInterface $MenuRepo)
    {
        $this->menuRepo = $MenuRepo;
    }

    public function index()
    {
        return response()->json($this->menuRepo->all());
    }

    public function getByModulo($id)
    {
        return response()->json($this->menuRepo->getByIdModulo($id));
    }

    public function store(Request $request)
    {
        $post = $this->menuRepo->create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json($this->menuRepo->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->menuRepo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->menuRepo->delete($id);
        return response()->json(null, 204);
    }
}
