<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showRegister(Request $request)
    {
        $allUsers = session('users', []);

        // search (title/description)
        $query = $request->query('query');
        $users = $allUsers;
        if ($query) {
            $users = array_values(array_filter($users, function ($u) use ($query) {
                return stripos($u['name'], $query) !== false || stripos($u['email'], $query) !== false;
            }));
        }

        // filter by status: all / pending / done
        $filter = $request->query('filter', 'all');
        if (in_array($filter, ['pending', 'done'])) {
            $users = array_values(array_filter($users, function ($u) use ($filter) {
                return isset($u['status']) && $u['status'] === $filter;
            }));
        }

        // find edit user from full list so it's selectable even when filtered
        $editUser = null;
        if ($request->query('edit')) {
            $id = (int) $request->query('edit');
            foreach ($allUsers as $u) {
                if ($u['id'] === $id) { $editUser = $u; break; }
            }
        }

        return view('register', [
            'users' => $users,
            'showUsers' => count($users) > 0,
            'accessDenied' => false,
            'editUser' => $editUser,
            'filter' => $filter,
            'query' => $query
        ]);
    }

    // Store a new user (session-based demo)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',    // title
            'email' => 'required|email',    // description (kept as email field for quick demo)
            'age' => 'required|integer'     // due / priority (kept numeric)
        ]);

        $users = session('users', []);
        $nextId = empty($users) ? 1 : (max(array_column($users, 'id')) + 1);
        $data['id'] = $nextId;
        $data['status'] = 'pending'; // new tasks start as pending
        $users[] = $data;
        session(['users' => $users]);

        return redirect('/register');
    }

    // Redirect to register with edit query so the form shows
    public function edit($id)
    {
        return redirect('/register?edit=' . (int) $id);
    }

    // Update an existing user in session
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'age' => 'required|integer'
        ]);

        $users = session('users', []);
        foreach ($users as &$u) {
            if ($u['id'] == $id) {
                $u['name'] = $data['name'];
                $u['email'] = $data['email'];
                $u['age'] = $data['age'];
                // keep existing status if present
                if (!isset($u['status'])) {
                    $u['status'] = 'pending';
                }
                break;
            }
        }
        session(['users' => $users]);

        return redirect('/register');
    }

    // Delete user from session
    public function destroy($id)
    {
        $users = session('users', []);
        $users = array_values(array_filter($users, function ($u) use ($id) {
            return $u['id'] != $id;
        }));
        session(['users' => $users]);

        return redirect('/register');
    }

    // Search handled by showRegister; this route reuses it
    public function search(Request $request)
    {
        return $this->showRegister($request);
    }

    // Bulk edit page
    public function editAll()
    {
        $users = session('users', []);
        return view('edit_all', ['users' => $users]);
    }

    // Bulk update from edit_all form
    public function updateAll(Request $request)
    {
        $input = $request->input('users', []);
        $users = [];
        foreach ($input as $id => $data) {
            $users[] = [
                'id' => (int) $id,
                'name' => $data['name'],
                'email' => $data['email'],
                'age' => (int) $data['age'],
                'status' => isset($data['status']) ? $data['status'] : 'pending'
            ];
        }
        session(['users' => $users]);
        return redirect('/register');
    }

    // Toggle status between pending and done
    public function toggleStatus($id)
    {
        $users = session('users', []);
        foreach ($users as &$u) {
            if ($u['id'] == $id) {
                $u['status'] = (isset($u['status']) && $u['status'] === 'done') ? 'pending' : 'done';
                break;
            }
        }
        session(['users' => $users]);
        return redirect()->back();
    }
}
