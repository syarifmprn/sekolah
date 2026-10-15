<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Menu::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_menu', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.menu.index', compact('data'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Menu::create($data);
        return redirect()->route('admin.menu.index')->with('success', 'Data created successfully');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->all();
        $menu->update($data);
        return redirect()->route('admin.menu.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Menu $menu)
    {
        
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Data deleted successfully');
    }
}
