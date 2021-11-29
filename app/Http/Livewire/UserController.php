<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserController extends Component
{
    public $products, $name, $email, $password, $mobile, $product_id;
    public $isDialogOpen = 0;

    public function render()
    {
        $this->products = User::all();
        return view('livewire.user-controller');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isDialogOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isDialogOpen = false;
    }

    private function resetCreateForm(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::updateOrCreate(['id' => $this->product_id], [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        session()->flash('message', $this->product_id ? 'Product updated!' : 'Product created!');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $product = User::findOrFail($id);
        $this->product_id = $id;
        $this->name = $product->name;
        $this->email = $product->email;
        $this->password = $product->password;
        $this->openModalPopover();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Product removed!');
    }
}
