<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Http\Resources\MenuResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Eager load parent, children, and page relationships
        return MenuResource::collection(
            Menu::with(['parent', 'children', 'page'])
                ->orderBy('order')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'     => 'required|string',
            'url'       => 'nullable|string',
            'page_id'   => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'order'     => 'integer|nullable',
            'location'  => 'nullable|string',
            'is_active' => 'boolean|nullable',
        ]);

        $menu = Menu::create($data);

        return new MenuResource($menu->load(['parent', 'children', 'page']));
    }

    public function show(Menu $menu)
    {
        return new MenuResource($menu->load(['parent', 'children', 'page']));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'label'     => 'sometimes|string',
            'url'       => 'nullable|string',
            'page_id'   => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:menus,id',
            'order'     => 'integer|nullable',
            'location'  => 'nullable|string',
            'is_active' => 'boolean|nullable',
        ]);

        $menu->update($data);

        return new MenuResource($menu->load(['parent', 'children', 'page']));
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json(['message' => 'Menu deleted']);
    }
}