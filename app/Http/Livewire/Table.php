<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;


class Table extends PowerGridComponent
{
    use ActionButton;

    public string $primaryKey = 'users.id';
    public string $sortField = 'users.id'; // Обязательно указывать первичные ключи


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp()
    {
        $this->showCheckBox() // Отображает четбоксы
            ->showPerPage(20) // Показывает раскрывающееся меню для выбора количества строк, отображаемых на странице
            ->showRecordCount(1-50)// Показывает количество записей внизу страницы
            ->showExportOption('download', ['excel', 'csv']) //кнопку экспорта вверху страницы
            ->showSearchInput(User::all()) // Включает функцию поиска и отображает поле ввода поиска вверху страницы
            ->showToggleColumns(); // Отображает кнопку для скрытия / отображения (переключения) столбцов

    }

    public function header(): array
    {
        $canClickButton = true;
        return [];
    }
    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Builder
    {
        return User::query()->with('account')
           /* ->join('accounts','users.id','=','accounts.user_id')
            ->select('users.*' ,'accounts.name as account_name');*/
            ->join('accounts', function ($categories) {
                $categories->on('users.id', '=', 'accounts.user_id');
            })
            ->select([
                'users.id',
                'accounts.id',
                'accounts.account_name as account_name','users.name as name','users.email as email','accounts.account_number as account_number',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */
    public function relationSearch(): array
    {
        return [
            'user' => ['name','email','id'],
            'account' => ['name','account_number','user_id','id'] // В приведенном примере добавляется связь с моделью и разрешается name поиск в столбце
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('user_id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('accounts')
            ->addColumn('real')
            ->addColumn('demo')
            ->addColumn('created_at_formatted', function(User $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })// В поле базы данных created_at хранится дата yyyy-mm-dd H:i:s
            ->addColumn('updated_at_formatted', function(User $model) {
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });

    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */
    public function columns(): array
    {
        $canCopy = true; //User has permission to copy
        $canEdit = true;
        return [
            Column::add()
                ->title(__('ID'))
                ->field('id')
                ->makeInputSelect(Account::all(), 'id', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('id'),

            Column::add()
                ->title(__('ACCOUNT NUMBER'))
                ->field('account_number')
                ->makeInputSelect(Account::all(), 'account_number', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('account_number'),

            Column::add()
                ->title(__('NAME'))
                ->field('name')
                ->editOnClick() // редактирование в один клик Важно: editOnClick при нажатии требует настройки метода обновления данных .
                ->makeInputSelect(User::all(), 'name', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('name')
                ->editOnClick($canEdit),


            Column::add()
                ->title(__('EMAIL'))
                ->field('email')
                ->editOnClick(true) // редактирование в один клик Важно: editOnClick при нажатии требует настройки метода обновления данных .
                ->makeInputSelect(User::all(), 'email', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('email'),// Добавляет фильтр ввода текста в столбец

            Column::add()
                ->title(__('ACCOUNTS'))
                ->field('account_name')
                ->makeInputSelect(Account::all(), 'account_name', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('account_name'),

            Column::add()
                ->title(__('PRODUCTS'))
                ->field('product')
                ->makeInputSelect(Account::all(), 'account_name', 'user_id',['live-search' => true]) //Включает определенное поле на страницу для фильтрации отношения hasOne в столбце
                ->makeInputText('account_name'),

            Column::add()
                ->title(__('CREATED AT'))
                ->field('created_at_formatted'),

            Column::add()// Добавляет новый столбец в таблицу PowerGrid
                ->title(__('UPDATED AT')) // Устанавливает заполнитель для этого столбца при использовании фильтра столбца. Устанавливает заголовок в заголовке столбца
                ->field('updated_at_formatted')// Связывает столбец с существующим полем источника данных или настраиваемым столбцом

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */

    public function actions(): array
    {
        $canClickButton = true; //User has permission to edit
       return [

    /*       Button::add('edit')// Кнопка редактирования
               ->target('_blank')
               ->caption(__('Edit'))
               ->class('bg-indigo-500 text-white')
               ->route('user.edit',['user' => 'id'])
               ->method('PUT'),*/

           /*Button::add('destroy') // Кнопка удаления
               ->caption(__('Delete'))
               ->class('bg-red-500 text-white')
               ->route('user.destroy', ['user' => 'id'])
               ->method('PUT')
               ->can($canClickButton)*/

        ];
    }
    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods
    |
    */


    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->join('accounts', function ($categories) {
               $categories->on('users.id', '=', 'accounts.user_id');
           })
               ->select([
                   'users.id',
                   'accounts.id',
                   'accounts.account_name as account_name','users.name as name','users.email as email','accounts.account_number as account_number',
               ])->find($data['id'])->update([
                $data['field'] => $data['value']
           ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status, string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field' => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field' => __('Error updating custom field.'),
            ]
        ];

        return ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);
    }


    public function template(): ?string
    {
        return null;
    }

    public $user;


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/dashboard')->with('success', 'Пользователь успешно удален');
    }

}
