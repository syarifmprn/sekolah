<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubMenu;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = SubMenu::query()->with('menu')->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_menu', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%")
                  ->orWhereHas('menu', function($q) use ($search) {
                      $q->where('nama_menu', 'like', "%{$search}%");
                  });
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.sub-menu.index', compact('data'));
    }

    public function create()
    {
        $menus = \App\Models\Menu::all();
        return view('admin.sub-menu.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        SubMenu::create($data);
        return redirect()->route('admin.sub-menu.index')->with('success', 'Data created successfully');
    }

    public function edit(SubMenu $subMenu)
    {
        $menus = \App\Models\Menu::all();
        return view('admin.sub-menu.edit', compact('subMenu', 'menus'));
    }

    public function update(Request $request, SubMenu $subMenu)
    {
        $data = $request->all();
        $subMenu->update($data);
        return redirect()->route('admin.sub-menu.index')->with('success', 'Data updated successfully');
    }

    public function destroy(SubMenu $subMenu)
    {
        
        $subMenu->delete();
        return redirect()->route('admin.sub-menu.index')->with('success', 'Data deleted successfully');
    }
}
